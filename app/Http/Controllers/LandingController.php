<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Traits\CalculateProfileMatchingTrait;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    use CalculateProfileMatchingTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data = [];
        if ($request->post('nisn')) {
            $nisn = $request->get('nisn');

            $student = Student::with(['major.competitions'])->where('nisn', $nisn)->firstOrFail();
            $data['student'] = $student;
            foreach ($student->major->competitions as $competition) {
                // add to data
                $data['meta'][] = [
                    'competition' => $competition->load('criterias'),
                    'matching' => $this->processCandidates($competition->id),
                ];
            }
        }

        return view('frontend.index', compact('data'));
    }
}
