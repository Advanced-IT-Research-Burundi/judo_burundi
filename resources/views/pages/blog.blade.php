@extends('layouts.user')
@section('content')
@section('title', 'Blog & Actualités')
<!-- Hero Section -->
	<section id="accueil" class="hero">
		<div class="container">
			<div class="hero-content">
				<h1>Fédération de Judo du Burundi</h1>
				<p>Post et Actualites</p>
				<a href="#programmes" class="cta-button">Découvrir nos programmes</a>
			</div>
		</div>
	</section>
	 <!-- Blog Section -->
	<section class="blog" id="blog">
		<div class="container">
			<div class="section-title">
				<h2>Blog & Actualités</h2>
				<p>Restez informé des dernières nouvelles et événements de la FBJ</p>
			</div>
			<div class="blog-grid">
				<div class="blog-post">
					<div class="post-image">📰</div>
					<div class="post-content">
						<h3>Tournoi National de Judo 2024</h3>
						<p>Le tournoi annuel de judo s'est tenu à Bujumbura avec
							plus de 200 participants de tout le pays.</p>
						<a href="#" class="read-more">Lire la suite</a>
					</div>
				</div>
				<div class="blog-post">
					<div class="post-image">🤼‍♂️</div>
						<div class="post-content">
						<h3>Formation des Instructeurs à Gitega</h3>
						<p>Une session de formation intensive pour les nouveaux
							instructeurs de judo a eu lieu à Gitega.</p>
						<a href="#" class="read-more">Lire la suite</a>
					</div>
				</div>
				<div class="blog-post">
					<div class="post-image">🌍</div>
						<div class="post-content">
						<h3>Participation aux Championnats Africains</h3>
						<p>Nos athlètes ont brillamment représenté le Burundi
							au dernier championnat africain de judo.</p>
						<a href="#" class="read-more">Lire la suite</a>
					</div>
				</div>
			</div>
		</div>
	</section>
</section>
@endsection

