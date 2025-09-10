@extends('layouts.user')
@section('content')
<div class="super_container">
	<!-- Header -->
	<!-- Hamburger -->
	
	<div class="hamburger_bar trans_400 d-flex flex-row align-items-center justify-content-start">
		<div class="hamburger">
			<div class="menu_toggle d-flex flex-row align-items-center justify-content-start">
				<span>menu</span>
				<div class="hamburger_container">
					<div class="menu_hamburger">
						<div class="line_1 hamburger_lines" style="transform: matrix(1, 0, 0, 1, 0, 0);"></div>
						<div class="line_2 hamburger_lines" style="visibility: inherit; opacity: 1;"></div>
						<div class="line_3 hamburger_lines" style="transform: matrix(1, 0, 0, 1, 0, 0);"></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Menu -->

	<div class="menu trans_800">
		<div class="menu_content d-flex flex-column align-items-center justify-content-center text-center">
			<ul>
				<li><a href="{{route('home')}}">Home</a></li>
				<li><a href="{{route('about')}}">About us</a></li>
				{{-- <li><a href="{{route('elements')}}">Classes & Services</a></li> --}}
				<li><a href="{{route('blog')}}">Blog</a></li>
				<li><a href="{{route('contact')}}">Contact</a></li>
			</ul>
		</div>
		<div class="menu_phone d-flex flex-row align-items-center justify-content-start">
			<i class="fa fa-phone" aria-hidden="true"></i>
				<span>652-345 3222 11</span>
		</div>
	</div>

	<!-- Home -->

	<div class="home">
		<div class="background_image" style="background-image:url(images/judo1.jpeg)"></div>
		<div class="overlay"></div>
		<div class="home_container">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="home_content text-center">
							{{-- <div class="video_link">
								<a class="vimeo video_button d-flex flex-column align-items-center justify-content-center" href="https://player.vimeo.com/video/99340873?autoplay=1&loop=1&title=0&autopause=0">
									<div class="video_link_content d-flex flex-row align-items-center justify-content-start">
										<div class="video_icon d-flex flex-column align-items-center justify-content-center"><i class="fa fa-play" aria-hidden="true"></i></div>
										<span class="video_text">See Workout Video</span>
									</div>
								</a>
							</div> --}}
							<div class="home_title">Get fit with us</div>
							<div class="home_subtitle">Pilates, Yoga, Fitness, Spinning & many more</div>
							<div class="button home_button ml-auto mr-auto"><a href="{{route('admin.joueurs.create')}}">Join Now</a></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Boxes -->

	{{-- <div class="boxes">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="boxes_container d-flex flex-lg-row flex-column align-items-start justify-content-start">
						
						<!-- Box -->
						<div class="box">
							<div class="box_icon d-flex flex-column align-items-center justify-content-center"><img src="images/icon_1.png" alt=""></div>
							<div class="box_title">Pilates with trainer</div>
							<div class="box_text">
								<p>Etiam commodo justo nec aliquam feugiat. Donec a leo eget augue porttitor sollicitudin.</p>
							</div>
							<div class="box_link_container">
								<a href="#"><div class="box_link d-flex flex-column align-items-center justify-content-center trans_200"><div>+</div></div></a>
							</div>
						</div>

						<!-- Box -->
						<div class="box">
							<div class="box_icon d-flex flex-column align-items-center justify-content-center"><img src="images/icon_2.png" alt=""></div>
							<div class="box_title">Swimming Pool</div>
							<div class="box_text">
								<p>Donec a leo eget augue porttitor sollicitudin. Morbi sed varius risus, vitae molestie lectus. Donec id hendrerit.</p>
							</div>
							<div class="box_link_container">
								<a href="#"><div class="box_link d-flex flex-column align-items-center justify-content-center trans_200"><div>+</div></div></a>
							</div>
						</div>

						<!-- Box -->
						<div class="box">
							<div class="box_icon d-flex flex-column align-items-center justify-content-center"><img src="images/icon_3.png" alt=""></div>
							<div class="box_title">Healthy diet plan</div>
							<div class="box_text">
								<p>Morbi sed varius risus, vitae molestie lectus. Donec id hendrerit velit, eu fringilla neque.</p>
							</div>
							<div class="box_link_container">
								<a href="#"><div class="box_link d-flex flex-column align-items-center justify-content-center trans_200"><div>+</div></div></a>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div> --}}

	<!-- About -->

	<div class="about">
		<div class="container about_container">
			<div class="row">
				<div class="col-lg-6">
					<div class="about_content">
						<div class="section_title_container">
							<div class="section_subtitle">welcome to sportfit</div>
							<div class="section_title">About <span>Sportfit</span></div>
						</div>
						<div class="text_highlight">Etiam commodo justo nec aliquam feugiat. Donec a leo eget eget augue porttitor sollicitudin augue porttitor sollicitudin.</div>
						<div class="about_text">
							<p>Morbi sed varius risus, vitae molestie lectus. Donec id hendrerit velit, eu fringilla neque. Etiam id finibus sapien. Donec sollicitudin luctus ex non pharetra. Aenean lobortis ut leo vel porta. Maecenas ac vestibulum lectus. Cras nulla urna, lacinia ut tempor facilisis, congue dignissim tellus. Maecenas ac vestibulum lectus. Cras nulla urna, lacinia ut tempor facilisis, congue dignissim tellus. Phasellus sit amet justo ullamcorper, elementum ipsum nec.</p>
						</div>
						{{-- <div class="button about_button"><a href="#">Join Now</a></div> --}}
					</div>
				</div>
			</div>
		</div>
		<div class="about_background">
			<div class="container fill_height">
				<div class="row fill_height">
					<div class="col-lg-6 offset-lg-6 fill_height">
						<div class="about_image"><img src="images/a1.png" alt=""></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Testimonials -->

	<div class="testimonials">
		<div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="images/testimonials.jpg" data-speed="0.8"></div>
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="section_title_container">
						<div class="section_subtitle">welcome to sportfit</div>
						<div class="section_title">Testimonials</div>
					</div>

					<!-- Testimonial -->
					<div class="test test_1 d-flex flex-row align-items-start justify-content-start">
						<div><div class="test_image"><img src="images/test_1.jpg" alt=""></div></div>
						<div class="test_content">
							<div class="test_name"><a href="#">Diane Smith</a></div>
							<div class="test_title">client</div>
							<div class="test_text">
								<p>Etiam nec odio vestibulum est mattis effic iturut magna. Pellentesque sit amet tellus blandit. Etiam nec odio vestibulum est mattis effic iturut magna. Pellentesque sit am et tellus blandit. Etiam nec odio vestibul. Etiam nec odio vestibulum est mat tis effic iturut magna.</p>
							</div>
							<div class="rating rating_4 test_rating"><i></i><i></i><i></i><i></i><i></i></div>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					
					<!-- Testimonial -->
					<div class="test d-flex flex-row align-items-start justify-content-start">
						<div><div class="test_image"><img src="images/test_2.jpg" alt=""></div></div>
						<div class="test_content">
							<div class="test_name"><a href="#">Diane Smith</a></div>
							<div class="test_title">client</div>
							<div class="test_text">
								<p>Etiam nec odio vestibulum est mattis effic iturut magna. Pellentesque sit amet tellus blandit. Etiam nec odio vestibulum est mattis effic iturut magna. Pellentesque sit am et tellus blandit. Etiam nec odio vestibul. Etiam nec odio vestibulum est mat tis effic iturut magna.</p>
							</div>
							<div class="rating rating_4 test_rating"><i></i><i></i><i></i><i></i><i></i></div>
						</div>
					</div>

					<!-- Testimonial -->
					<div class="test d-flex flex-row align-items-start justify-content-start">
						<div><div class="test_image"><img src="images/test_3.jpg" alt=""></div></div>
						<div class="test_content">
							<div class="test_name"><a href="#">Diane Smith</a></div>
							<div class="test_title">client</div>
							<div class="test_text">
								<p>Etiam nec odio vestibulum est mattis effic iturut magna. Pellentesque sit amet tellus blandit. Etiam nec odio vestibulum est mattis effic iturut magna. Pellentesque sit am et tellus blandit. Etiam nec odio vestibul. Etiam nec odio vestibulum est mat tis effic iturut magna.</p>
							</div>
							<div class="rating rating_4 test_rating"><i></i><i></i><i></i><i></i><i></i></div>
						</div>
					</div>

				</div>
			</div>
			<div class="row test_button_row">
				<div class="col text-center">
					<div class="button test_button"><a href="#">Join Now</a></div>
				</div>
			</div>
		</div>
	</div>

	<!-- Gallery -->

	<div class="gallery">
		
		<!-- Gallery Slider -->
		<div class="gallery_slider_container">
			<div class="owl-carousel owl-theme gallery_slider">
				
				<!-- Slide -->
				<div class="owl-item"><img src="images/gallery_3.jpg" alt=""></div>

				<!-- Slide -->
				<div class="owl-item"><img src="images/gallery_4.jpg" alt=""></div>

				<!-- Slide -->
				<div class="owl-item"><img src="images/gallery_5.jpg" alt=""></div>

				<!-- Slide -->
				<div class="owl-item"><img src="images/gallery_1.jpg" alt=""></div>

				<!-- Slide -->
				<div class="owl-item"><img src="images/gallery_2.jpg" alt=""></div>

			</div>
		</div>
	</div>

	<!-- Blog -->

	<div class="blog">
		<div class="blog_overlay"></div>
		<div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="images/blog.jpg" data-speed="0.8"></div>
		<div class="container">
			<div class="row">
				<div class="col">
					<div class=" d-flex flex-row align-items-start justify-content-start">
						<div class="section_title_container">
							<div class="section_subtitle">welcome to sportfit</div>
							<div class="section_title">The Blog</div>
						</div>
						{{-- <div class="all_posts_link ml-auto"><a href="#">View all blog posts</a></div> --}}
					</div>
				</div>
			</div>
			<div class="row blog_row">
				
				<!-- Blog Post -->
				<div class="col-lg-4 blog_col">
					<div class="blog_post">
						<div class="blog_post_image"><img src="images/blog_1.jpg" alt=""></div>
						<div class="blog_post_title"><a href="#">Tips for the perfect body</a></div>
						<div class="blog_post_date"><a href="#">june 29, 2018</a></div>
						<div class="blog_post_text">
							<p>Etiam nec odio vestibulum est mattis effic iturut magna. Pellentesque sit amet tellus blandit. Odio vestibulum est mattis effic iturut.</p>
						</div>
						<div class="blog_post_link"><a href="#">Read More</a></div>
					</div>
				</div>

				<!-- Blog Post -->
				<div class="col-lg-4 blog_col">
					<div class="blog_post">
						<div class="blog_post_image"><img src="images/blog_2.jpg" alt=""></div>
						<div class="blog_post_title"><a href="#">Tips for the perfect body</a></div>
						<div class="blog_post_date"><a href="#">june 29, 2018</a></div>
						<div class="blog_post_text">
							<p>Etiam nec odio vestibulum est mattis effic iturut magna. Pellentesque sit amet tellus blandit. Odio vestibulum est mattis effic iturut.</p>
						</div>
						<div class="blog_post_link"><a href="#">Read More</a></div>
					</div>
				</div>

				<!-- Blog Post -->
				<div class="col-lg-4 blog_col">
					<div class="blog_post">
						<div class="blog_post_image"><img src="images/blog_3.jpg" alt=""></div>
						<div class="blog_post_title"><a href="#">Video: Pilates 4 Begginers</a></div>
						<div class="blog_post_date"><a href="#">june 29, 2018</a></div>
						<div class="blog_post_text">
							<p>Etiam nec odio vestibulum est mattis effic iturut magna. Pellentesque sit amet tellus blandit. Odio vestibulum est mattis effic iturut.</p>
						</div>
						<div class="blog_post_link"><a href="#">Read More</a></div>
					</div>
				</div>

			</div>
		</div>
	</div>

</div>
@endsection
