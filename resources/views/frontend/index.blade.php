<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="description" content="Edumel- Education Html Template by dreambuzz">
    <meta name="keywords"
        content="education,edumel,instructor,lms,online,instructor,dreambuzz,bootstrap,kindergarten,tutor,e learning">
    <meta name="author" content="dreambuzz">

    <title>{{ config('app.name') }}</title>

    <!-- Mobile Specific Meta-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- bootstrap.min css -->
    <link rel="stylesheet" href="{{ asset('frontend/vendors/bootstrap/bootstrap.css') }}">
    <!-- Iconfont Css -->
    <link rel="stylesheet" href="{{ asset('frontend/vendors/awesome/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendors/flaticon/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/fonts/gilroy/font-gilroy.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendors/magnific-popup/magnific-popup.css') }}">
    <!-- animate.css -->
    <link rel="stylesheet" href="{{ asset('frontend/vendors/animate-css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendors/animated-headline/animated-headline.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendors/owl/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendors/owl/assets/owl.theme.default.min.css') }}">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('frontend/css/woocomerce.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">

</head>

<body id="top-header">
    <header class="header-style-2">
        <div class="header-topbar topbar-noticebar">
            <div class="container-fluid container-padding">
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-8">
                        <div class="header-notice text-center">
                            Untuk kembali ke situs resmi SMKN 1 Panji.
                            <a href="https://www.smkn1panji-sit.sch.id/">
                                Klik Disini
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-navbar menu-2 navbar-sticky">
            <div class="container-fluid container-padding">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="site-logo" style="max-width: 360px;font-size: 24px;font-weight: bold;">
                        {{ config('app.name') }}
                    </div>

                    <div class="offcanvas-icon d-block d-lg-none">
                        <a href="#" class="nav-toggler"><i class="fal fa-bars"></i></a>
                    </div>

                    <nav class="site-navbar ms-auto">
                        <ul class="primary-menu">
                            <li><a href="#">Beranda</a></li>
                            <li><a href="#tentang">Tentang</a></li>
                            <li><a href="#bagaimana">Kontak</a></li>
                        </ul>

                        <a href="#" class="nav-close"><i class="fal fa-times"></i></a>
                    </nav>

                    @auth
                        <div class="header-btn border-left-0 ms-3 d-none d-lg-block">
                            <a href="{{ url('admin') }}" class="btn btn-grey-outline btn-sm-2 rounded"><i
                                    class="fal fa-user me-2"></i>Admin Panel</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>
    <!--====== Header End ======-->
    <!-- Banner Section Start -->
    <section class="banner banner-style-1">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12 col-xl-6 col-lg-6">
                    <div class="banner-content">
                        <h1>Sistem Informasi Lomba Kompetensi Siswa
                            SMK Siap Unggul, Berprestasi dalam LKS</h1>
                        <p>Platform internal untuk mendukung perencanaan, monitoring, dan pengembangan siswa dalam
                            mengikuti Lomba Kompetensi Siswa di tingkat sekolah, daerah, maupun nasional.</p>

                        <div class="banner-form me-5">
                            <form id="searchForm" action="{{ route('frontend') }}" method="POST" class="form">
                                @csrf
                                <input type="text" class="form-control" name="nisn"
                                    placeholder="NISN: ex (0021xxxxx)"
                                    value="{{ old('nisn', request()->post('nisn')) }}">
                                <a href="#"
                                    onclick="document.getElementById('searchForm').submit(); return false;">
                                    Search <i class="far fa-search"></i>
                                </a>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-xl-6 col-lg-6">
                    <div class="banner-img-round mt-5 mt-lg-0">
                        <img src="{{ asset('frontend/images/banner/banner_img.png') }}" alt=""
                            class="img-fluid">
                    </div>
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section>
    <!-- Banner Section End -->

    @if (isset($data) && isset($data['meta']))
        <!-- Feature section start -->
        <section class="features-2">
            <div class="container">
                <h4>Detail Siswa</h4>
                <div class="card card-body my-3">
                    <div class="row">
                        <div class="col-xl-6 col-sm-12 col-lg-6">
                            <p>NISN: {{ $data['student']->nisn }}</p>
                            <p>Nama: {{ $data['student']->name }}</p>
                            <p>Jurusan: {{ $data['student']->major->name }}</p>
                            <p class="mb-0">Kelas: {{ $data['student']->classroom->name }}</p>
                        </div>
                    </div>
                </div>
                @foreach ($data['meta'] as $d)
                    @php
                        // Extract all criterias linked to the competition
                        $criterias = $d['competition']->criterias;
                    @endphp
                    <div class="row my-3">
                        <div class="col-xl-12 pe-xl-12 col-lg-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4>{{ $d['competition']->name }}</h4>
                                <button class="btn btn-sm-2 btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#detail{{ $d['competition']->id }}Modal">Lihat Detail</button>
                            </div>
                            <div class="card card-body mt-3">
                                <div class="table-responsive">
                                    <table class="table table-bordered w-100 m-0">
                                        <thead class="text-center table-secondary">
                                            <tr>
                                                <th>
                                                    {{ __('candidate.column.name') }}
                                                </th>
                                                <th>
                                                    {{ __('candidate.table.end-score') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($d['matching']['topStudents'] as $student)
                                                <tr
                                                    class="{{ $student->nisn == $data['student']->nisn ? 'table-primary' : '' }}">
                                                    <td>
                                                        {{ $student->name }}
                                                        @if ($student->nisn == $data['student']->nisn)
                                                            <span class="badge bg-primary">Anda</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $d['matching']['studentMappingScores'][$student->id]['total_score'] }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="detail{{ $d['competition']->id }}Modal" tabindex="-1"
                        aria-labelledby="detail{{ $d['competition']->id }}ModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Detail Perhitungan Lomba
                                        {{ $d['competition']->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="d-grid gap-3 pb-2">
                                        <button class="btn btn-sm-2 btn-primary" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $d['competition']->id }}StartScore"
                                            aria-expanded="false"
                                            aria-controls="collapse{{ $d['competition']->id }}StartScore">
                                            {{ __('candidate.table.start-score') }}
                                        </button>
                                        <button class="btn btn-sm-2 btn-primary" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $d['competition']->id }}WeightingScore"
                                            aria-expanded="false"
                                            aria-controls="collapse{{ $d['competition']->id }}WeightingScore">
                                            {{ __('candidate.table.weighting-score') }}
                                        </button>
                                        <button class="btn btn-sm-2 btn-primary" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $d['competition']->id }}ConvertionScore"
                                            aria-expanded="false"
                                            aria-controls="collapse{{ $d['competition']->id }}ConvertionScore">
                                            {{ __('candidate.table.convertion-score') }}
                                        </button>
                                        <button class="btn btn-sm-2 btn-primary" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $d['competition']->id }}GroupingScore"
                                            aria-expanded="false"
                                            aria-controls="collapse{{ $d['competition']->id }}GroupingScore">
                                            {{ __('candidate.table.grouping-score') }}
                                        </button>
                                    </div>
                                    <div class="row">
                                        <div class="collapse mb-3"
                                            id="collapse{{ $d['competition']->id }}StartScore">
                                            <div class="card card-body">
                                                <h6 class="card-title">{{ __('candidate.table.start-score') }}</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered w-100 m-0">
                                                        <thead class="text-center table-secondary">
                                                            <tr>
                                                                <th class="text-center" rowspan="2">
                                                                    {{ __('candidate.column.name') }}</th>
                                                                @foreach ($criterias as $criteria)
                                                                    <th class="px-3 py-3.5 text-center"
                                                                        colspan="{{ count($criteria->subjects) }}">
                                                                        {{ $criteria->name }}
                                                                        ({{ $criteria->weight }}%)
                                                                    </th>
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                @foreach ($criterias as $criteria)
                                                                    @foreach ($criteria->subjects as $subject)
                                                                        <th style="min-width: 120px">
                                                                            {{ $subject->name }}
                                                                            <br>
                                                                            <span
                                                                                class="badge bg-{{ $subject->pivot->type->getColor() }}">
                                                                                {{ $subject->pivot->type->getSmallLabel() }}
                                                                            </span>
                                                                        </th>
                                                                    @endforeach
                                                                @endforeach
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-center">
                                                            @foreach ($d['matching']['students'] as $student)
                                                                <tr
                                                                    class="{{ $student->nisn == $data['student']->nisn ? 'table-primary' : '' }}">
                                                                    <td>
                                                                        {{ $student->name }}
                                                                        @if ($student->nisn == $data['student']->nisn)
                                                                            <span class="badge bg-primary">Anda</span>
                                                                        @endif
                                                                    </td>
                                                                    @foreach ($criterias as $criteria)
                                                                        @foreach ($criteria->subjects as $subject)
                                                                            @php
                                                                                $score = $student->subjects->firstWhere(
                                                                                    'id',
                                                                                    $subject->id,
                                                                                )?->pivot->score;
                                                                            @endphp
                                                                            <td>{{ $score ?? 0 }}</td>
                                                                        @endforeach
                                                                    @endforeach
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot class="text-center table-secondary">
                                                            <tr>
                                                                <th>{{ __('candidate.table.targeted-score') }}</th>
                                                                @foreach ($criterias as $criteria)
                                                                    @foreach ($criteria->subjects as $subject)
                                                                        <th>{{ $subject->pivot->target_score }}
                                                                        </th>
                                                                    @endforeach
                                                                @endforeach
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse mb-3"
                                            id="collapse{{ $d['competition']->id }}WeightingScore">
                                            <div class="card card-body">
                                                <h6 class="card-title">{{ __('candidate.table.weighting-score') }}
                                                </h6>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered w-100 m-0">
                                                        <thead class="text-center table-secondary">
                                                            <tr>
                                                                <th rowspan="2">{{ __('candidate.column.name') }}
                                                                </th>
                                                                @foreach ($criterias as $criteria)
                                                                    <th class="px-3 py-3.5"
                                                                        colspan="{{ count($criteria->subjects) }}">
                                                                        {{ $criteria->name }}
                                                                        ({{ $criteria->weight }}%)
                                                                    </th>
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                @foreach ($criterias as $criteria)
                                                                    @foreach ($criteria->subjects as $subject)
                                                                        <th style="min-width: 120px">
                                                                            {{ $subject->name }}
                                                                            <br>
                                                                            <span
                                                                                class="badge bg-{{ $subject->pivot->type->getColor() }}">
                                                                                {{ $subject->pivot->type->getSmallLabel() }}
                                                                            </span>
                                                                        </th>
                                                                    @endforeach
                                                                @endforeach
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-center">
                                                            @foreach ($d['matching']['students'] as $student)
                                                                <tr
                                                                    class="{{ $student->nisn == $data['student']->nisn ? 'table-primary' : '' }}">
                                                                    <td>
                                                                        {{ $student->name }}
                                                                        @if ($student->nisn == $data['student']->nisn)
                                                                            <span class="badge bg-primary">Anda</span>
                                                                        @endif
                                                                    </td>
                                                                    @foreach ($criterias as $criteria)
                                                                        <td>
                                                                            {{ $d['matching']['studentMappingScores'][$student->id][$criteria->id]['type_totals']['core'] ?? 0 }}
                                                                        </td>
                                                                        <td>
                                                                            {{ $d['matching']['studentMappingScores'][$student->id][$criteria->id]['type_totals']['secondary'] ?? 0 }}
                                                                        </td>
                                                                        <td>
                                                                            {{ $d['matching']['studentMappingScores'][$student->id][$criteria->id]['total_weighted_score'] }}
                                                                        </td>
                                                                    @endforeach
                                                                </tr>
                                                            @endforeach
                                                            <tr class="table-secondary">
                                                                <th>
                                                                    {{ __('candidate.table.targeted-score') }}
                                                                </th>
                                                                @foreach ($criterias as $criteria)
                                                                    @foreach ($criteria->subjects as $subject)
                                                                        <td>
                                                                            {{ $d['matching']['subjectTargetedScores'][$subject->id] }}
                                                                        </td>
                                                                    @endforeach
                                                                @endforeach
                                                            </tr>
                                                            @foreach ($d['matching']['students'] as $student)
                                                                <tr=>
                                                                    <td>
                                                                        {{ $student->name }}
                                                                    </td>
                                                                    @foreach ($criterias as $criteria)
                                                                        @foreach ($criteria->subjects as $subject)
                                                                            <td>
                                                                                {{ $d['matching']['studentMappingScores'][$student->id][$criteria->id][$subject->id]['gap'] ?? 0 }}
                                                                            </td>
                                                                        @endforeach
                                                                    @endforeach
                                                                    </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse mb-3"
                                            id="collapse{{ $d['competition']->id }}ConvertionScore">
                                            <div class="card card-body">
                                                <h6 class="card-title">{{ __('candidate.table.convertion-score') }}
                                                </h6>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered w-100 m-0">
                                                        <thead class="text-center table-secondary">
                                                            <tr>
                                                                <th rowspan="2">{{ __('candidate.column.name') }}
                                                                </th>
                                                                @foreach ($criterias as $criteria)
                                                                    <th class="px-3 py-3.5"
                                                                        colspan="{{ count($criteria->subjects) }}">
                                                                        {{ $criteria->name }}
                                                                        ({{ $criteria->weight }}%)
                                                                    </th>
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                @foreach ($criterias as $criteria)
                                                                    @foreach ($criteria->subjects as $subject)
                                                                        <th style="min-width: 120px">
                                                                            {{ $subject->name }}
                                                                            <br>
                                                                            <span
                                                                                class="badge bg-{{ $subject->pivot->type->getColor() }}">
                                                                                {{ $subject->pivot->type->getSmallLabel() }}
                                                                            </span>
                                                                        </th>
                                                                    @endforeach
                                                                @endforeach
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-center">
                                                            @foreach ($d['matching']['students'] as $student)
                                                                <tr
                                                                    class="{{ $student->nisn == $data['student']->nisn ? 'table-primary' : '' }}">
                                                                    <td>
                                                                        {{ $student->name }}
                                                                        @if ($student->nisn == $data['student']->nisn)
                                                                            <span class="badge bg-primary">Anda</span>
                                                                        @endif
                                                                    </td>
                                                                    @foreach ($criterias as $criteria)
                                                                        @foreach ($criteria->subjects as $subject)
                                                                            <td class="text-center">
                                                                                {{ $d['matching']['studentMappingScores'][$student->id][$criteria->id][$subject->id]['score'] ?? 0 }}
                                                                            </td>
                                                                        @endforeach
                                                                    @endforeach
                                                                </tr>
                                                            @endforeach
                                                            <tr class="table-secondary">
                                                                <th>
                                                                    {{ __('candidate.table.targeted-score') }}
                                                                </th>
                                                                @foreach ($criterias as $criteria)
                                                                    @foreach ($criteria->subjects as $subject)
                                                                        <td>
                                                                            {{ $d['matching']['subjectTargetedScores'][$subject->id] }}
                                                                        </td>
                                                                    @endforeach
                                                                @endforeach
                                                            </tr>
                                                            @foreach ($d['matching']['students'] as $student)
                                                                <tr=>
                                                                    <td>
                                                                        {{ $student->name }}
                                                                    </td>
                                                                    @foreach ($criterias as $criteria)
                                                                        @foreach ($criteria->subjects as $subject)
                                                                            <td>
                                                                                {{ $d['matching']['studentMappingScores'][$student->id][$criteria->id][$subject->id]['gap'] ?? 0 }}
                                                                            </td>
                                                                        @endforeach
                                                                    @endforeach
                                                                    </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse mb-3"
                                            id="collapse{{ $d['competition']->id }}GroupingScore">
                                            <div class="card card-body">
                                                <h6 class="card-title">{{ __('candidate.table.grouping-score') }}
                                                </h6>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered w-100 m-0">
                                                        <thead class="text-center table-secondary">
                                                            <tr>
                                                                <th rowspan="2">
                                                                    {{ __('candidate.column.name') }}
                                                                </th>
                                                                @foreach ($criterias as $criteria)
                                                                    <th colspan="3">
                                                                        {{ $criteria->name }}
                                                                        ({{ $criteria->weight }}%)
                                                                    </th>
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                @foreach ($criterias as $criteria)
                                                                    @foreach (App\Enum\CompetitionCriteriaSubjectType::cases() as $type)
                                                                        <th>
                                                                            <div
                                                                                class="badge bg-{{ $type->getColor() }}">
                                                                                {{ $type->getSmallLabel() }}
                                                                            </div>
                                                                        </th>
                                                                    @endforeach
                                                                    <th>
                                                                        <div class="badge bg-primary">
                                                                            NA
                                                                        </div>
                                                                    </th>
                                                                @endforeach
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-center">
                                                            @foreach ($d['matching']['students'] as $student)
                                                                <tr
                                                                    class="{{ $student->nisn == $data['student']->nisn ? 'table-primary' : '' }}">
                                                                    <td>
                                                                        {{ $student->name }}
                                                                        @if ($student->nisn == $data['student']->nisn)
                                                                            <span class="badge bg-primary">Anda</span>
                                                                        @endif
                                                                    </td>
                                                                    @foreach ($criterias as $criteria)
                                                                        <td>
                                                                            {{ $d['matching']['studentMappingScores'][$student->id][$criteria->id]['type_totals']['core'] ?? 0 }}
                                                                        </td>
                                                                        <td>
                                                                            {{ $d['matching']['studentMappingScores'][$student->id][$criteria->id]['type_totals']['secondary'] ?? 0 }}
                                                                        </td>
                                                                        <td>
                                                                            {{ $d['matching']['studentMappingScores'][$student->id][$criteria->id]['total_weighted_score'] }}
                                                                        </td>
                                                                    @endforeach
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @else
        <!-- Feature section start -->
        <section class="features-2">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-3 col-md-6 col-xl-3 col-sm-6">
                        <div class="feature-item feature-style-top mb-4 mb-lg-0">
                            <div class="feature-icon">
                                <i class="flaticon-teacher"></i>
                            </div>
                            <div class="feature-text">
                                <h4>Pembimbimng Kompeten</h4>
                                <p>Pendampingan siswa oleh guru pembimbing sesuai bidang lomba
                                    keahlian.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-xl-3 col-sm-6">
                        <div class="feature-item feature-style-top mb-4 mb-lg-0">
                            <div class="feature-icon">
                                <i class="flaticon-layer"></i>
                            </div>
                            <div class="feature-text">
                                <h4>Pengembangan Kompetensi</h4>
                                <p>Fasilitasi latihan dan evaluasi untuk mempersiapkan siswa
                                    menghadapi LKS.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-xl-3 col-sm-6">
                        <div class="feature-item feature-style-top mb-4 mb-lg-0">
                            <div class="feature-icon">
                                <i class="flaticon-video-camera"></i>
                            </div>
                            <div class="feature-text">
                                <h4>Pembelajaran Fleksibel</h4>
                                <p>Materi dan tugas LKS dapat diakses secara daring oleh siswa
                                    dan pembimbing.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-xl-3 col-sm-6">
                        <div class="feature-item feature-style-top">
                            <div class="feature-icon">
                                <i class="flaticon-lifesaver"></i>
                            </div>
                            <div class="feature-text">
                                <h4>Pendampingan Berkelanjutan</h4>
                                <p>Monitoring dan evaluasi secara berkala terhadap progres siswa
                                    peserta LKS. </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Feature section End -->
        <!-- Feature Section Start -->
        <section class="features section-padding-btm" id="tentang">
            <div class="container">
                <div class="row align-items-center justify-content-end mb-50">
                    <div class="col-xl-6 pe-xl-5 col-lg-6">
                        <img src="{{ asset('frontend/images/banner/banner_img.pn') }}g" alt=""
                            class="img-fluid">
                    </div>

                    <div class="col-xl-6 col-lg-6 ">
                        <div class="section-heading mt-5 mt-lg-0 mb-4">
                            <span class="subheading">Perspektif Pembelajaran Konstruktif dalam LKS</span>
                            <h2 class="mb-20 font-lg">Membangun Keterampilan Siswa untuk Berprestasi di Lomba
                                Kompetensi
                                Siswa</h2>
                            <p>Platform untuk meningkatkan kemampuan siswa dalam mengikuti Lomba Kompetensi Siswa (LKS)
                                melalui pembelajaran konstruktif dan terstruktur.</p>
                        </div>

                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="single-course-category style-2">
                                    <div class="course-cat-icon">
                                        <img src="{{ asset('frontend/images/icon/icon6.png') }}" alt=""
                                            class="img-fluid">
                                    </div>
                                    <div class="course-cat-content">
                                        <h4 class="course-cat-title">
                                            <a href="#">IT Software Solution for Business</a>
                                        </h4>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="single-course-category style-2 ">
                                    <div class="course-cat-icon">
                                        <img src="{{ asset('frontend/images/icon/icon1.png') }}" alt=""
                                            class="img-fluid">
                                    </div>
                                    <div class="course-cat-content">
                                        <h4 class="course-cat-title">
                                            <a href="#">Elektronika</a>
                                        </h4>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="single-course-category style-2">
                                    <div class="course-cat-icon">
                                        <img src="{{ asset('frontend/images/icon/icon3.png') }}" alt=""
                                            class="img-fluid">
                                    </div>
                                    <div class="course-cat-content">
                                        <h4 class="course-cat-title">
                                            <a href="#">Digital Marketing</a>
                                        </h4>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="single-course-category style-2">
                                    <div class="course-cat-icon">
                                        <img src="{{ asset('frontend/images/icon/icon4.png') }}" alt=""
                                            class="img-fluid">
                                    </div>
                                    <div class="course-cat-content">
                                        <h4 class="course-cat-title">
                                            <a href="#">3D Game Art</a>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Feature Section END -->

        <!-- Work Process Section Start -->
        <section class="work-process section-padding-btm" id="bagaimana">
            <div class="container">
                <div class="row mb-70 justify-content-between">
                    <div class="col-xl-5 col-lg-6">
                        <div class="section-heading mb-4 mb-xl-0">
                            <span class="subheading">Bagaimana cara Untuk Memulai</span>
                            <h2 class="font-lg">4 langkah untuk memulai perjalanan Anda:</h2>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <p>Sistem ini dirancang untuk mempermudah proses seleksi dan pendaftaran LKS secara adil dan
                            transparan. Peserta hanya dapat memilih lomba yang sesuai dengan jurusannya, dan penilaian
                            dilakukan berdasarkan akumulasi nilai rapor serta hasil pembinaan.</p>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-xl-12 pe-xl-12 col-lg-12">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="step-item ">
                                    <div class="step-number bg-1">01</div>
                                    <div class="step-text">
                                        <h5>Pengisian Data Siswa</h5>
                                        <p>Lengkapi biodata dan informasi jurusan Anda. Sistem hanya akan menampilkan
                                            lomba
                                            sesuai jurusan</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="step-item">
                                    <div class="step-number bg-2">02</div>
                                    <div class="step-text">
                                        <h5>Verifikasi Nilai Rapor</h5>
                                        <p>Nilai rapor digunakan sebagai dasar akumulasi penilaian awal dalam proses
                                            seleksi.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="step-item ">
                                    <div class="step-number bg-3">03</div>
                                    <div class="step-text">
                                        <h5>Pelatihan Kompetensi</h5>
                                        <p>Ikuti program pelatihan sesuai bidang lomba yang tersedia untuk jurusan Anda.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="step-item ">
                                    <div class="step-number bg-1">04</div>
                                    <div class="step-text">
                                        <h5>Penetapan Peserta LKS</h5>
                                        <p>Peserta dengan nilai terbaik dan hasil pelatihan yang optimal akan ditetapkan
                                            sebagai wakil sekolah.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Work Process Section End -->
    @endif

    <!-- Footer section start -->
    <section class="footer footer-4 pt-200">
        <div class="footer-mid">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 me-auto col-sm-8">
                        <div class="footer-logo mb-3">
                            <h1 class="text-white">{{ config('app.name') }}</h1>
                        </div>
                        <div class="widget footer-widget mb-5 mb-lg-0">
                            <p>Aplikasi seleksi dan pendataan peserta Lomba Kompetensi Siswa (LKS) tingkat SMK</p>
                        </div>
                    </div>

                    <div class="col-xl-2 col-sm-4">
                        <div class="footer-widget mb-5 mb-xl-0">
                            <h5 class="widget-title">Lainnya</h5>
                            <ul class="list-unstyled footer-links">
                                <li><a href="https://smkn1panji-sit.sch.id">Website Sekolah</a></li>
                                <li><a
                                        href="https://pusatprestasinasional.kemdikbud.go.id/event/riset-dan-inovasi/smk/lomba-kompetensi-siswa-nasional-2025-2025-smk">Website
                                        LKS</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-xl-2 col-sm-4">
                        <div class="footer-widget mb-5 mb-xl-0">
                            <h5 class="widget-title">Kontak</h5>
                            <ul class="list-unstyled footer-links">
                                <li>
                                    <h6 class="text-white">Phone</h6><a href="#">0338 - 672507</a>
                                </li>
                                <li>
                                    <h6 class="text-white">Email</h6><a href="#">info@smkn1panji-sit.sch.id</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-btm">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-sm-12 col-lg-6">
                        <p class="mb-0 copyright text-sm-center text-lg-start">© {{ date('Y') }}
                            {{ config('app.name') }} All rights reserved</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="fixed-btm-top">
            <a href="#top-header" class="js-scroll-trigger scroll-to-top"><i class="fa fa-angle-up"></i></a>
        </div>

    </section>
    <!-- Footer section End -->




    <!--
    Essential Scripts
    =====================================-->

    <!-- Main jQuery -->
    <script src="{{ asset('frontend/vendors/jquery/jquery.js') }}"></script>
    <!-- Bootstrap 5:0 -->
    <script src="{{ asset('frontend/vendors/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('frontend/vendors/bootstrap/bootstrap.js') }}"></script>
    <!-- Counterup -->
    <script src="{{ asset('frontend/vendors/counterup/waypoint.js') }}"></script>
    <script src="{{ asset('frontend/vendors/counterup/jquery.counterup.min.js') }}"></script>
    <!--  Owl Carousel -->
    <script src="{{ asset('frontend/vendors/owl/owl.carousel.min.js') }}"></script>
    <!-- Isotope -->
    <script src="{{ asset('frontend/vendors/isotope/jquery.isotope.js') }}"></script>
    <script src="{{ asset('frontend/vendors/isotope/imagelaoded.min.js') }}"></script>
    <!-- Animated Headline -->
    <script src="{{ asset('frontend/vendors/animated-headline/animated-headline.js') }}"></script>
    <!-- Magnific Popup -->
    <script src="{{ asset('frontend/vendors/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

    <script src="{{ asset('frontend/js/script.js') }}"></script>


</body>

</html>
