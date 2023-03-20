document.addEventListener('DOMContentLoaded', function () {
	setTimeout(function () {
		// Convert the div to image (canvas)
		html2canvas(document.getElementById('container2')).then(function (canvas) {
			// Get the image data as JPEG and 0.9 quality (0.0 - 1.0)
			//console.log(canvas.toDataURL("image/jpeg", 0.9));
			let data = canvas.toDataURL('image/png', 0.9)

			let image = new Image()
			image.src = data
			document.getElementById('image').appendChild(image)

			// Create an AJAX object
			let ajax = new XMLHttpRequest()

			// Setting method, server file name, and asynchronous
			ajax.open('POST', '../add_data.php', true)

			// Setting headers for POST method
			ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')

			// Sending image data to server
			ajax.send('image=' + canvas.toDataURL('image/png', 0.9))

			// Receiving response from server
			// This function will be called multiple times
			ajax.onreadystatechange = function () {
				// Check when the requested is completed
				if (this.readyState == 4 && this.status == 200) {
					// Displaying response from server
					// console.log(this.responseText)
				}
			}
		})
	}, 1500)
})
// Get the current page scroll position
//scrollTop = window.pageYOffset || document.documentElement.scrollTop;
//scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,

//scrollTop = 0;
//scrollLeft = 0;
// if any scroll is attempted,
// set this to the previous value
//window.onscroll = function() {
//window.scrollTo(scrollLeft, scrollTop);
//};
