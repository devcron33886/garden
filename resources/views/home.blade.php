@extends('layouts.app')
@section('styles')
@endsection

@section('title','|Home')

@section('content')
 <livewire:home-page :slides="$slides" :categories="$categories" />
@endsection

@section('scripts')
    <script src="{{ asset('js/my-animation.min.js') }}"></script>
    <script>
        $('.center').slick({
            centerMode: true,
            centerPadding: '60px',
            slidesToShow: 3,
            autoplay: true,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 1
                    }
                }
            ]
        });
    </script>
@endsection
