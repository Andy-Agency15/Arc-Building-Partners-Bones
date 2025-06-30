<?php
/*
 Template Name: Service Page Template
*/
get_header();
?>
<!-- Banner Section -->
<section class="services-banner">
	<div class="banner-content">
		<h1>Services</h1>
	</div>
</section>

<!-- Services Section -->
<section class="services-section">
	<!-- Left Column - Services List -->
	<div class="services-list">
		<div class="service-item active" data-service="audit">
			<h3>Audit + Accounting</h3>
		</div>
		<div class="service-item" data-service="tax">
			<h3>Tax</h3>
		</div>
		<div class="service-item" data-service="business">
			<h3>Business Valuation + Consulting</h3>
		</div>
		<div class="service-item" data-service="wealth">
			<h3>Wealth Management</h3>
		</div>
		<div class="service-item" data-service="outsourced">
			<h3>Outsourced Accounting</h3>
		</div>
		<div class="service-item" data-service="mergers">
			<h3>Mergers + Acquisitions</h3>
		</div>
	</div>

	<!-- Right Column - Sub Services -->
	<div class="sub-services" id="sub-services">
		<div class="sub-services-grid" id="sub-services-content">
			<!-- Content will be populated by JavaScript -->
		</div>
	</div>
</section>

<?php
get_footer();
