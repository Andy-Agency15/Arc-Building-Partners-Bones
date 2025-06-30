gsap.registerPlugin(ScrollTrigger)

if (typeof gsap !== "undefined") {
	console.log("GSAP is loaded")
} else {
	console.log("GSAP is not loaded")
}

// Main Nav Toggle
document.getElementById("nav-toggle").addEventListener("click", function () {
	const navToggle = document.getElementById("nav-toggle")
	const navMenu = document.getElementById("nav-menu")
	const navInner = document.querySelector(".nav-menu .inner")

	// Get position and size of nav-toggle
	const toggleRect = navToggle.getBoundingClientRect()

	if (!navMenu.classList.contains("nav-menu-active")) {
		gsap.set(navMenu, {
			top: toggleRect.top,
			left: toggleRect.left,
			width: toggleRect.width,
			height: toggleRect.height,
			borderRadius: "50%",
			opacity: 1,
			display: "block",
		})

		gsap.to(navMenu, {
			top: 0,
			left: 0,
			width: "100%",
			height: "100vh",
			borderRadius: "0px",
			duration: 0.6,
			ease: "power2.out",
			onUpdate: function () {
				// Square off the top-right corner faster
				gsap.set(navMenu, {
					borderTopRightRadius:
						Math.max(0, 100 - this.progress() * 300) + "px",
				})
			},
			onComplete: () => {
				gsap.to(navInner, {
					opacity: 1,
					duration: 0.3,
					ease: "power2.out",
				})
			},
		})

		navMenu.classList.add("nav-menu-active")
	} else {
		gsap.to(navInner, {
			opacity: 0,
			duration: 0.2,
			ease: "power2.in",
		})

		gsap.to(navMenu, {
			top: toggleRect.top,
			left: toggleRect.left,
			width: toggleRect.width,
			height: toggleRect.height,
			borderRadius: "100px",
			duration: 0.6,
			ease: "power2.in",
			onUpdate: function () {
				// Make the top-right corner round off faster on close
				gsap.set(navMenu, {
					borderTopRightRadius:
						Math.min(100, this.progress() * 50) + "px",
				})
			},
			onComplete: () => {
				navMenu.style.display = "none"
				navMenu.classList.remove("nav-menu-active")
			},
		})
	}

	navToggle.classList.toggle("nav-toggle-active")
})

const Portfolio = {
	init() {
		if (!document.querySelector(".portfolio-grid")) return

		// Sample project data (replace with your ACF data later)
		const portfolioProjects = [
			{
				id: 1,
				title: "Modern Office Complex",
				service: "commercial",
				sector: "office",
				image: "https://images.unsplash.com/photo-1497366216548-37526070297c?w=1200&h=800&fit=crop",
			},
			{
				id: 2,
				title: "Luxury Residential Tower",
				service: "residential",
				sector: "residential",
				image: "https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=1200&h=800&fit=crop",
			},
			{
				id: 3,
				title: "Boutique Hotel Design",
				service: "interior",
				sector: "hospitality",
				image: "https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1200&h=800&fit=crop",
			},
			{
				id: 4,
				title: "Retail Flagship Store",
				service: "commercial",
				sector: "retail",
				image: "https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1200&h=800&fit=crop",
			},
			{
				id: 5,
				title: "Historic Building Renovation",
				service: "renovation",
				sector: "office",
				image: "https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1200&h=800&fit=crop",
			},
			{
				id: 6,
				title: "Penthouse Interior",
				service: "interior",
				sector: "residential",
				image: "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=1200&h=800&fit=crop",
			},
			{
				id: 7,
				title: "Restaurant Design",
				service: "interior",
				sector: "hospitality",
				image: "https://images.unsplash.com/photo-1514933651103-005eec06c04b?w=1200&h=800&fit=crop",
			},
			{
				id: 8,
				title: "Corporate Headquarters",
				service: "commercial",
				sector: "office",
				image: "https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1200&h=800&fit=crop",
			},
		]

		class PortfolioViewer {
			constructor() {
				this.currentView = "a"
				this.currentSlide = 0
				this.filteredProjects = [...portfolioProjects]
				this.activeFilters = {
					service: "all",
					sector: "all",
				}

				this.init()
			}

			init() {
				this.setupEventListeners()
				this.generateContent()
				this.updateActiveView()
			}

			setupEventListeners() {
				// View toggle buttons
				document
					.getElementById("view-a-btn")
					.addEventListener("click", () => this.switchView("a"))
				document
					.getElementById("view-b-btn")
					.addEventListener("click", () => this.switchView("b"))

				// Dropdown triggers
				document
					.getElementById("service-dropdown-trigger")
					.addEventListener("click", (e) => {
						e.stopPropagation()
						this.toggleDropdown("service")
					})

				document
					.getElementById("sector-dropdown-trigger")
					.addEventListener("click", (e) => {
						e.stopPropagation()
						this.toggleDropdown("sector")
					})

				// Dropdown items
				document.querySelectorAll(".dropdown-item").forEach((item) => {
					item.addEventListener("click", (e) =>
						this.handleDropdownSelection(e)
					)
				})
				// Project list toggle
				document
					.getElementById("project-list-btn")
					.addEventListener("click", (e) => {
						e.stopPropagation()
						this.toggleProjectList()
					})

				// Close dropdowns and project list when clicking outside
				document.addEventListener("click", () => {
					this.closeAllDropdowns()
					this.closeProjectList()
				})

				document
					.getElementById("reset-filters-btn")
					.addEventListener("click", () => this.resetFilters())
			}

			switchView(view) {
				this.currentView = view
				this.updateActiveView()
				this.updateViewToggle()
			}

			updateActiveView() {
				const viewA = document.getElementById("view-a")
				const viewB = document.getElementById("view-b")

				if (this.currentView === "a") {
					viewA.style.display = "block"
					viewB.style.display = "none"
				} else {
					viewA.style.display = "none"
					viewB.style.display = "block"
				}
			}

			updateViewToggle() {
				document
					.querySelectorAll(".view-toggle button")
					.forEach((btn) => {
						btn.classList.remove("active")
					})
				document
					.getElementById(`view-${this.currentView}-btn`)
					.classList.add("active")
			}

			toggleDropdown(type) {
				const dropdown = document.getElementById(`${type}-dropdown`)
				const trigger = document.getElementById(
					`${type}-dropdown-trigger`
				)
				const isOpen = dropdown.classList.contains("open")

				// Close all other dropdowns
				this.closeAllDropdowns()

				// Toggle current dropdown
				if (!isOpen) {
					dropdown.classList.add("open")
					trigger.classList.add("open")
				}
			}

			closeAllDropdowns() {
				document
					.querySelectorAll(".dropdown-menu")
					.forEach((dropdown) => {
						dropdown.classList.remove("open")
					})
				document
					.querySelectorAll(".dropdown-trigger")
					.forEach((trigger) => {
						trigger.classList.remove("open")
					})
			}

			handleDropdownSelection(e) {
				const item = e.target
				const filterType = item.dataset.type
				const filterValue = item.dataset.filter

				// Update active filter
				this.activeFilters[filterType] = filterValue

				// Update dropdown items
				document
					.querySelectorAll(`[data-type="${filterType}"]`)
					.forEach((dropdownItem) => {
						dropdownItem.classList.remove("active")
					})
				item.classList.add("active")

				// Update trigger text
				const trigger = document.getElementById(
					`${filterType}-dropdown-trigger`
				)
				const selectedValue = trigger.querySelector(".selected-value")
				selectedValue.textContent = item.textContent

				// Close dropdown
				this.closeAllDropdowns()

				// Apply filters
				this.applyFilters()
			}

			handleFilter(e) {
				const button = e.target
				const filterType = button.dataset.type
				const filterValue = button.dataset.filter

				// Update active filter
				this.activeFilters[filterType] = filterValue

				// Update button states
				document
					.querySelectorAll(`[data-type="${filterType}"]`)
					.forEach((btn) => {
						btn.classList.remove("active")
					})
				button.classList.add("active")

				// Apply filters
				this.applyFilters()
			}

			resetFilters() {
				// Reset active filters
				this.activeFilters = {
					service: "all",
					sector: "all",
				}

				// Reset current slide
				this.currentSlide = 0

				// Update dropdown items to show "All" as active
				document.querySelectorAll(".dropdown-item").forEach((item) => {
					item.classList.remove("active")
					if (item.dataset.filter === "all") {
						item.classList.add("active")
					}
				})

				// Update dropdown trigger text
				const serviceTrigger = document.getElementById(
					"service-dropdown-trigger"
				)
				const sectorTrigger = document.getElementById(
					"sector-dropdown-trigger"
				)

				serviceTrigger.querySelector(".selected-value").textContent =
					"All"
				sectorTrigger.querySelector(".selected-value").textContent =
					"All"

				// Close any open dropdowns
				this.closeAllDropdowns()
				this.closeProjectList()

				// Apply the reset (this will show all projects)
				this.applyFilters()
			}

			toggleProjectList() {
				const dropdown = document.getElementById(
					"project-list-dropdown"
				)
				const trigger = document.getElementById("project-list-btn")
				const isOpen = dropdown.classList.contains("open")

				if (isOpen) {
					this.closeProjectList()
				} else {
					// Close other dropdowns first
					this.closeAllDropdowns()
					dropdown.classList.add("open")
					trigger.classList.add("active")
					this.generateProjectList()
				}
			}

			closeProjectList() {
				const dropdown = document.getElementById(
					"project-list-dropdown"
				)
				const trigger = document.getElementById("project-list-btn")
				dropdown.classList.remove("open")
				trigger.classList.remove("active")
			}

			generateProjectList() {
				const listContainer =
					document.getElementById("project-list-items")
				const countElement = document.getElementById("project-count")

				// Update count
				countElement.textContent = `${
					this.filteredProjects.length
				} Project${this.filteredProjects.length !== 1 ? "s" : ""}`

				// Clear existing items
				listContainer.innerHTML = ""

				if (this.filteredProjects.length === 0) {
					listContainer.innerHTML =
						'<div class="project-list-empty">No projects match your filters</div>'
					return
				}

				// Generate list items
				this.filteredProjects.forEach((project, index) => {
					const item = document.createElement("div")
					item.className = `project-list-item ${
						index === this.currentSlide ? "active" : ""
					}`
					item.innerHTML = `<a href="#" class="project-link">${project.title}</a>`

					// Add click handler to jump to project
					const link = item.querySelector(".project-link")
					link.addEventListener("click", (e) => {
						e.preventDefault()
						this.goToSlide(index)
						this.closeProjectList()
						// Switch to slideshow view if in grid
						if (this.currentView === "b") {
							this.switchView("a")
						}
					})

					listContainer.appendChild(item)
				})
			}

			applyFilters() {
				this.filteredProjects = portfolioProjects.filter((project) => {
					const serviceMatch =
						this.activeFilters.service === "all" ||
						project.service === this.activeFilters.service
					const sectorMatch =
						this.activeFilters.sector === "all" ||
						project.sector === this.activeFilters.sector
					return serviceMatch && sectorMatch
				})

				// Reset current slide if needed
				if (this.currentSlide >= this.filteredProjects.length) {
					this.currentSlide = 0
				}

				// Regenerate content
				this.generateContent()
			}

			generateContent() {
				this.generateSlideshow()
				this.generateGrid()
			}

			generateSlideshow() {
				const slideshowContainer = document.getElementById(
					"slideshow-container"
				)
				const carouselNav = document.getElementById("carousel-nav")

				// Clear existing content
				slideshowContainer.innerHTML = ""
				carouselNav.innerHTML = ""

				if (this.filteredProjects.length === 0) {
					slideshowContainer.innerHTML =
						'<div class="slide active" style="display: flex; align-items: center; justify-content: center; font-size: 2rem; opacity: 0.5;">No projects match your filters</div>'
					return
				}

				// Generate slides
				this.filteredProjects.forEach((project, index) => {
					const slide = document.createElement("div")
					slide.className = `slide ${
						index === this.currentSlide ? "active" : ""
					}`
					slide.style.backgroundImage = `url(${project.image})`
					slide.innerHTML = `
            <div class="slide-overlay">
                <div class="slide-content">
                    <h2>${project.title}</h2>
                    <div class="meta">
                        <span class="service">${project.service}</span>
                        <span class="sector">${project.sector}</span>
                    </div>
                    <div class="project-controls">
                        <a href="#" class="view-project-btn">View Project</a>
                        <div class="slide-arrows">
                            <div class="inline-arrow arrow-prev" data-action="prev">
                                <svg width="24px" height="24px" viewBox="0 0 24 24">
                                    <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
                                </svg>
                            </div>
                            <div class="inline-arrow arrow-next" data-action="next">
                                <svg width="24px" height="24px" viewBox="0 0 24 24">
                                    <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `
					slideshowContainer.appendChild(slide)

					// Generate carousel thumb
					const thumb = document.createElement("div")
					thumb.className = `carousel-thumb ${
						index === this.currentSlide ? "active" : ""
					}`
					thumb.style.backgroundImage = `url(${project.image})`
					thumb.addEventListener("click", () => this.goToSlide(index))
					carouselNav.appendChild(thumb)
				})

				// Add event listeners to inline arrows
				this.setupInlineArrows()
				this.updateArrowStates()
			}

			prevSlide() {
				if (this.filteredProjects.length <= 1) return

				this.currentSlide =
					this.currentSlide === 0
						? this.filteredProjects.length - 1
						: this.currentSlide - 1

				this.updateSlideshow()
				this.updateArrowStates()
			}

			nextSlide() {
				if (this.filteredProjects.length <= 1) return

				this.currentSlide =
					(this.currentSlide + 1) % this.filteredProjects.length
				this.updateSlideshow()
				this.updateArrowStates()
			}

			updateArrowStates() {
				const prevArrows = document.querySelectorAll(".arrow-prev")
				const nextArrows = document.querySelectorAll(".arrow-next")

				// Disable arrows if only one or no projects
				if (this.filteredProjects.length <= 1) {
					prevArrows.forEach((arrow) =>
						arrow.classList.add("disabled")
					)
					nextArrows.forEach((arrow) =>
						arrow.classList.add("disabled")
					)
				} else {
					prevArrows.forEach((arrow) =>
						arrow.classList.remove("disabled")
					)
					nextArrows.forEach((arrow) =>
						arrow.classList.remove("disabled")
					)
				}
			}

			setupInlineArrows() {
				// Remove old listeners to prevent duplicates
				document.querySelectorAll(".inline-arrow").forEach((arrow) => {
					arrow.replaceWith(arrow.cloneNode(true))
				})

				// Add new listeners
				document.querySelectorAll(".inline-arrow").forEach((arrow) => {
					arrow.addEventListener("click", (e) => {
						e.stopPropagation()
						const action = arrow.dataset.action
						if (action === "prev") {
							this.prevSlide()
						} else if (action === "next") {
							this.nextSlide()
						}
					})
				})
			}

			generateGrid() {
				const grid = document.getElementById("projects-grid")
				grid.innerHTML = ""

				if (this.filteredProjects.length === 0) {
					grid.innerHTML =
						'<div style="grid-column: 1 / -1; text-align: center; font-size: 2rem; opacity: 0.5; padding: 100px 0;">No projects match your filters</div>'
					return
				}

				this.filteredProjects.forEach((project) => {
					const card = document.createElement("div")
					card.className = "project-card"
					card.style.backgroundImage = `url(${project.image})`
					card.innerHTML = `
                        <div class="card-overlay">
                            <div class="card-content">
                                <h3>${project.title}</h3>
                                <div class="meta">
                                    <span class="service">${project.service}</span>
                                    <span class="sector">${project.sector}</span>
                                </div>
								<div class="project-links">
									<a href="#" class="view-project-btn">View Project</a>
								</div>
                            </div>
                        </div>
                    `
					grid.appendChild(card)
				})
			}

			goToSlide(index) {
				this.currentSlide = index
				this.updateSlideshow()
			}

			updateSlideshow() {
				const slides = document.querySelectorAll(".slide")
				const thumbs = document.querySelectorAll(".carousel-thumb")

				slides.forEach((slide, index) => {
					slide.classList.toggle(
						"active",
						index === this.currentSlide
					)
				})

				thumbs.forEach((thumb, index) => {
					thumb.classList.toggle(
						"active",
						index === this.currentSlide
					)
				})
			}

			// Auto-advance slideshow (optional)
			startAutoAdvance() {
				setInterval(() => {
					if (
						this.currentView === "a" &&
						this.filteredProjects.length > 1
					) {
						this.currentSlide =
							(this.currentSlide + 1) %
							this.filteredProjects.length
						this.updateSlideshow()
					}
				}, 5000)
			}
		}

		// Initialize the portfolio
		document.addEventListener("DOMContentLoaded", () => {
			const portfolioViewer = new PortfolioViewer()
		})
		// Uncomment to enable auto-advance
		// portfolioViewer.startAutoAdvance();
	},
}
