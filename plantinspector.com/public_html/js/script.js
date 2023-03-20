document.addEventListener('DOMContentLoaded', function () {
	const burgerIcon = document.querySelector('.burger-icon')
	const nav = document.querySelector('.nav-items-mobile')

	let viewportWidth = 0
	
	const allNavLinks = document.querySelectorAll('.nav-link')
	
	// hide burger menu when link is clicked
	allNavLinks.forEach(link => link.addEventListener('click', () => nav.classList.add('hide')))
	
	
	// chech the window width on every resize to hide mobile menu on desktop/tablet
	window.addEventListener('resize', () => {
		viewportWidth = window.innerWidth
		if (viewportWidth >= 768) {
			nav.classList.add('hide')
		}
	})
	
	// show menu when burger icon is clicked on mobile
	burgerIcon.addEventListener('click', () => {
		nav.classList.toggle('hide')
	})

	// const navList = document.querySelector('ul')
	// const navLinkFirst = document.querySelector('.first')
	// const navListLinks = document.querySelectorAll('.menu-list')
	// navListLinks.forEach(link => link.addEventListener('click', () => navList.classList.add('hideList')))
})
// function used to display images in fullscreen with the posibility to exit it with another mouse click instead of esc key
// $(document).ready(function(){$("img").click(function(){this.requestFullscreen()})});
	// $(document).ready(function () {
	// 	$('.photo').click(function () {
	// 		if (document.fullscreenElement) {
	// 			document.exitFullscreen()
	// 		} else {
	// 			this.requestFullscreen()
	// 		}
	// 	})
	// })
