@extends('frontend.layouts.app')

@section('title', $page->meta_title ?? $page->title)
@section('description', $page->meta_description ?? '')

@section('content')
    @foreach ($page->sections as $section)
        @includeIf('frontend.sections.' . $section->section_type, ['section' => $section])
    @endforeach
@endsection
