<div id="content" class="app-content">
<audio id="audio" style="display: none;" controls allow="autoplay"><source src="<?= base_url() ?>assets/assets/audio/popup.ogg" type="audio/mpeg"></audio>

<h1 class="page-header">Halaman Dashboard</h1>


</div>

<script type="text/javascript">
function autoplay(){
    var r =true;
    if (r == true) {
        document.getElementById("audio").play();
    }
  }
</script>
<script>
    $( document ).ready(function() {
    autoplay();
});

</script> 