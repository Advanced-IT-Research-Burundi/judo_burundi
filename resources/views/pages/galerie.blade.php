@extends('layouts.user')
@section('content')
    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <h1>NOTRE GALERIE</h1>
            <p>Découvrez JUDO traditionnel avec nos instructeurs légendaires</p>
            <div class="hero-buttons">

                <button class="btn-primary" onclick="openModal()">Commencer maintenant</button>
                <button class="btn-secondary">En savoir plus</button>
            </div>
        </div>
    </section>
    <!-- Gallery Section -->
    <section class="gallery" id="gallery">
        <div class="container">
            <div class="section-title">
                <h2>Galerie Photos</h2>
                <p>Découvrez notre académie en images</p>
            </div>
            <div class="gallery-grid">
                <div class="gallery-item">
                    <div
                        style="height: 100%; background: #ddd; display: flex; align-items: center; justify-content: center; color: #666;">
                        {{-- <i class="fas fa-image" style="font-size: 2rem;"></i> --}}
                        <img src="/images/judo3.jpg" alt="Gallery Image"
                            style="height: 100%; width: auto; border-radius: 10px;">
                    </div>
                </div>
                <div class="gallery-item">
                    <div
                        style="height: 100%; background: #ddd; display: flex; align-items: center; justify-content: center; color: #666;">
                        {{-- <i class="fas fa-image" style="font-size: 2rem;"></i> --}}
                        <img src="/images/judo4.jpg" alt="Gallery Image"
                            style="height: 100%; width: auto; border-radius: 10px;">
                    </div>
                </div>
                <div class="gallery-item">
                    <div
                        style="height: 100%; background: #ddd; display: flex; align-items: center; justify-content: center; color: #666;">
                        {{-- <i class="fas fa-image" style="font-size: 2rem;"></i> --}}
                        <img src="/images/judo5.jpg" alt="Gallery Image"
                            style="height: 100%; width: auto; border-radius: 10px;">

                    </div>
                </div>
                <div class="gallery-item">
                    <div
                        style="height: 100%; background: #ddd; display: flex; align-items: center; justify-content: center; color: #666;">
                        {{-- <i class="fas fa-image" style="font-size: 2rem;"></i> --}}
                        <img src="/images/judo6.jpg" alt="Gallery Image"
                            style="height: 100%; width: auto; border-radius: 10px;">

                    </div>
                </div>
                <div class="gallery-item">
                    <div
                        style="height: 100%; background: #ddd; display: flex; align-items: center; justify-content: center; color: #666;">
                        {{-- <i class="fas fa-image" style="font-size: 2rem;"></i> --}}
                        <img src="/images/judoimage1.jpg" alt="Gallery Image"
                            style="height: 100%; width: auto; border-radius: 10px;">
                    </div>
                </div>
                <div class="gallery-item">
                    <div
                        style="height: 100%; background: #ddd; display: flex; align-items: center; justify-content: center; color: #666;">
                        {{-- <i class="fas fa-image" style="font-size: 2rem;"></i> --}}
                        <img src="/images/judoimage1.jpg" alt="Gallery Image"
                            style="height: 100%; width: auto; border-radius: 10px;">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
