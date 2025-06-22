<script src="https://cdn.tiny.cloud/1/axsu6fezayf8yo9tyfcc8wzfnjnqea7kez3xg05s865zxlwy/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('konten')) {
      tinymce.init({
        selector: 'textarea#konten',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        height: 500,
        branding: false,
        // --- Perbaikan di sini: Atur skin dan content_css secara eksplisit ke tema terang ---
        skin: 'oxide', // Mengatur skin editor ke tema terang (default TinyMCE)
        content_css: 'default', // Mengatur CSS konten editor ke tema terang (default)
        // --- Akhir perbaikan ---

        // image_upload_handler: (blobInfo, progress) => new Promise((resolve, reject) => { /* ... */ }),
      });
    }
  });
</script>