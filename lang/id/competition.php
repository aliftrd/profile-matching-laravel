<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Table Columns
    |--------------------------------------------------------------------------
    */

    'column.name' => 'Nama',
    'column.major' => 'Jurusan',
    'column.updated_at' => 'Dirubah',
    'column.criteria.name' => 'Nama',
    'column.criteria.weight' => 'Bobot',
    'column.criteria.subjects' => 'Mata Pelajaran Terkait',
    'column.criteria.updated_at' => 'Dirubah',

    /*
    |--------------------------------------------------------------------------
    | Form Fields
    |--------------------------------------------------------------------------
    */

    'field.name' => 'Nama',
    'field.major' => 'Jurusan',
    'field.criteria.name' => 'Nama',
    'field.criteria.weight' => 'Bobot',
    'field.criteria.subjects' => 'Mata Pelajaran Terkait',
    'field.criteria.subject' => 'Mata Pelajaran',
    'field.criteria.subject.type' => 'Tipe',
    'field.criteria.subject.target-score' => 'Nilai Ideal',

    /*
    |--------------------------------------------------------------------------
    | Form Validation
    |--------------------------------------------------------------------------
    */

    'validation.criteria.max_criteria_total_weight' => 'Total bobot kriteria tidak boleh melebihi :max%',
    'validation.criteria.max_subject_total_weight' => 'Total bobot mata pelajaran tidak boleh melebihi :max%',

    /*
    |--------------------------------------------------------------------------
    | Navigation & Resource
    |--------------------------------------------------------------------------
    */

    'nav.label' => 'Bidang Lomba',
    'nav.group' => 'Lomba',
    'nav.icon' => 'heroicon-o-trophy',
    'nav.criteria.title' => 'Kriteria',
    'nav.criteria.label' => 'Kriteria Lomba',
    'nav.criteria.icon' => 'heroicon-o-numbered-list',
    'nav.candidate.title' => 'Kandidat',
    'nav.candidate.label' => 'Kandidat Lomba',
    'nav.candidate.icon' => 'heroicon-o-trophy'
];
