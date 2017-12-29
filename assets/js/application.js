// apply template js
// document.addEventListener("DOMContentLoaded", function() {
//   masonryBuild();
//   navbarToggleSidebar();
//   navActivePage();
// });

// preview image
$('.workImageInput').on('change', function() {
  var selectedFile = this.files[0];
  var fileReader = new FileReader();
  var $output = $(this).parent().find('.workImageOutput');

  fileReader.onload = function(e) {
    var loadedImage = e.target.result;
    $output.css(
      'background-image', 'url(' + loadedImage + ')'
    );
  };
  fileReader.readAsDataURL(selectedFile);
});
