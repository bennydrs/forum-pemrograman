<nav aria-label="breadcrumb">
<ol class="breadcrumb">
   <li class="breadcrumb-item">
        <i class="fa fa-dashboard"></i> <a href="<?php echo site_url('thread'); ?>">Home</a>
   </li>
   <li class="breadcrumb-item active">
        Bantuan
   </li>
</ol>
</nav>
<br>


<div class="row">
  <div class="col-sm-3">
  		<button class="d-block d-sm-none btn btn-light" type="button" data-toggle="collapse" data-target="#navbarsExample08" aria-controls="navbarsExample08" aria-expanded="false" aria-label="Toggle navigation">
				<i class="glyphicon glyphicon-menu-hamburger"></i>
			</button>
		
		<div class="nav flex-column nav-pills d-none d-sm-block collapse" id="navbarsExample08">
			 
			  <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Topik</a>
			  <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Buat Topik</a>
			  <!-- <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a> -->
		</div>	
  </div>
  <div class="col-sm-9">
    <div class="tab-content" id="v-pills-tabContent">
      
      <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
	  		<div class="page-header">
			  <h3>Topik Dan Post Balas</h3>
			</div>
			<nav class="nav flex-column">
				<a class="nav-link page_scroll pd active" href="#topik">Topik</a>
				<a class="nav-link page_scroll pd" href="#post_balas">Post Balas</a>
				<a class="nav-link page_scroll pd" href="#quote">Qoute</a>
				<a class="nav-link page_scroll pd" href="#perbedaan">Perbedaan Topik & Post Balas</a>
				<a class="nav-link page_scroll pd" href="#edit">Edit Topik</a>
				<a class="nav-link page_scroll pd" href="#like">Like</a>
				<a class="nav-link page_scroll pd" href="#love">Love</a>
				<a class="nav-link page_scroll pd" href="#top_post">Top Post</a>
			</nav>
			<br>
			
			<style>.pd {
				padding-bottom: 2px;
				padding-top: 2px;
			}</style>

			<h5 id="topik"><strong>Topik</strong></h5>
				<p class="pt-2">Topik merupakan suatu pokok dari sebuah pembiaraan atau sesuatu yang akan menjadi ladasan 
					dalam penulisan sebuah pembicaraan atau artikel.</p>
				<p>Pada forum pemrograman ini, topik terdiri dari 3 jenis yaitu:</p>
			
				<ol>
					<li>Tanya</li>
						<p>Jenis topik ini untuk menanyakan sesuatu tentang pemrograman komputer.</p>
					<li>Diskusi</li>
						<p>Jenis topik ini untuk mendiskusikan suatu topik tentang pemrograman komputer. misalnya 
							mendiskusikan fitur-fitur baru pada bahasa pemrograman dan lain sebagainya.
						</p>
					<li>Berbagi</li>
						<p>Jenis topik ini untuk membagikan ilmu atau informasi tentang pemrograman komputer seperti tips dan trik, algoritma, metode baru dan lain sebagainya.</p>
				</ol>
			<br>

			

			<h5 id="post_balas"><strong>Post Balas</strong></h5>
				<p class="pt-2">Post balas adalah balasan pada setiap topik yang telah dibuat serdiri atau member lain. </p>
				<p>Langkah menulis post balas:</p>
				<ol>
					<li>Pilih dan klik judul topik dihalaman depan.</li>
					<li>Tulis post balas pada box post balas di bagian bawah halaman.</li>
				</ol>
			<br>

			<h5 id="edit"><strong>Edit Topik</strong></h5>
				<p>Langkah mengedit topik:</p>
				<ol>
					<li>Masuk ke topik yang sudah kamu buat.</li>
					<li>Klik tanda <i class="glyphicon glyphicon-option-vertical"></i> di bagian kanan atas topik anda.</li>
					<li>Pilih "Edit".</li>
					<li>Ganti atau ubah konten yang ingin diubah lalu klik <strong>"Simpan"</strong>. </li>
				</ol>
			<br>

			<h5 id="quote"><strong>Quote</strong></h5>
				<p class="pt-2">Quote dapat digunakan sebagai acuan dalam bentuk kutipan langsung jika ingin mengutip satu post balas (Quote).</p>
				<p>Langkah menyertakan quote:</p>
				<ol>
					<li>Pilih dan klik judul topik dihalaman depan.</li>
					<li>Klik <strong>"Balas/Quote"</strong>pada suatu post balas.</li>
					<li>Tulis pada text editor balas/qoute lalu klik <strong>"Post Qoute"</strong>.</li>
				</ol>
			<br>

			<h5 id="perbedaan"><strong>Perbedaan Topik dan Post Balas</strong></h5>
				<p><img class="border" src="<?php echo base_url('assets/image_help/topik.png') ?>" alt="" width="100%"></p>
				<br>

			<h5 id="like"><strong>Like</strong></h5>	

				<p class="pt-2">Like digunakan oleh member apabila suatu post balas disukai atau sesuai dengan jawaban yang ditanyakan.
					Like juga digunakan untuk menentukan suatu jawaban atau post balas member lain masuk pada <strong>top post</strong>.
				</p>
			<br>

			<h5 id="love"><strong>Love</strong></h5> 
				<p class="pt-2">Fitur love hanya ada pada jenis topik <strong>Tanya</strong>. Love hanya digunakan oleh penulis atau penanya, 
				yang berfungsi apabila jawaban atau post balas yang ditulis member lain sesuai yang diharapkan oleh penulis atau penanya.
				Love juga berfungsi untuk menentukan suatu jawaban atau post balas member lain masuk pada <strong>top post</strong>
				</p>
			<br>

			<h5 id="top_post"><strong>Top Post</strong></h5> 
				<p class="pt-2">Top post merupakan <strong>post balas</strong> pada suatu topik dengan jenis topik tanya yang paling banyak 
					di like dan yang mendapatkan love dari penulis topik.</p>
					<p>Suatu post balas akan menjadi top post apabila dua unsur terpenuhi yaitu like dari penulis atau member lain dan love dari penulis.</p>
				<p>Post balas yang menjadi top post bisa menjadi acuan bahwa post balas tersebut sesuai apa yang di ditanyakan
					oleh seorang penulis (member) pada topik</p>
	  		<!-- <p>Topik adalah hal yang pertama kali ditentukan ketika penulis akan membuat tulisan.
				Topik yang masih awal tersebut, selanjutnya dikembangkan dengan membuat cakupan yang lebih sempit atau lebih luas.
				Terdapat beberapa kriteria untuk sebuah topik yang dikatakan baik, diantaranya adalah topik tersebut harus mencakup keseluruhan isi tulisan, yakni mampu menjawab pertanyaan akan masalah apa yang hendak ditulis.</p> -->
			
	</div>
      <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
		<div class="page-header">
				<h2>Buat Topik</h2>
		</div>
		<nav class="nav flex-column">
			<a class="nav-link page_scroll active" href="#buat_topik">Buat Topik</a>
			<a class="nav-link page_scroll" href="#insert_link">Insert Link</a>
			<a class="nav-link page_scroll" href="#insert_code">Insert Code Sample</a>
			<a class="nav-link page_scroll" href="#insert_video">Memasukkan Video</a>
		</nav>
		<br>

		<div class="page-header" id="buat_topik">
			<h4>Buat Topik</h4>
		</div>
		
			<p>Langkah Buat Topik:</p>

				<ul>
					
					<ol>
						<li>Klik <strong>"Buat Topik"</strong> untuk membuat topik baru.</li>				
						<li>Cantumkan judul topik pada <strong>box Judul</strong>.</li>
						<li>Pilih kategori topik pada <strong>box Kategori</strong>.</li>
						<li>Pilih jenis topik pada<strong>box jenis topik</strong>.</li>
						<li>Ketik isi topik Agan di <strong>box post pertama</strong>.</li>
						<li>Klik "<strong> Buat Topik</strong>".</li>
					</ol>
					
				</ul>

			
		<br>
		<div class="page-header" id="insert_link">
			<h4>Insert Link</h4>
		</div>
		
			<p> Anda dapat memasukkan link pada topik untuk informasi tambahan.</p>
			<p>Langkah memasukkan link:</p>
			<ul>
				<ol>
				<li>Copy link URL.</li>
				<li>Klik ikon <strong>"Insert Link"</strong> pada text editor.</li>
				<li>Paste link URL yang telah dicopy pada box url.</li>
				<li>Masukkan judul atau teks yang diinginkan, untuk menggantikan link URL tersebut.</li>
				<li>pilih target dan Klik <strong>"OK"</strong></li>
				</ol>
			</ul>
			
			<br>
		<div class="page-header" id="insert_code">
			<h4>Insert Code Sample</h4>
		</div>
		
			<p> Anda dapat memasukkan code sampel pada topik untuk menampilkan source code yang rapih dan menarik.</p>
			<p>Langkah memasukkan code sample:</p>
			<ul>
				<ol>
				<li>Copy source code.</li>
				<li>Klik ikon <strong>"Insert code sample"</strong> pada text editor.</li>
				<li>Pilih bahasa pemrograman yang sesuai dengan source code yang telah dicopy pada box language.</li>
				<li>Paste lsource code yang telah dicopy dan Klik <strong>"OK"</strong>.</li>
				</ol>
			</ul>

			<br>
		<div class="page-header" id="insert_video">
			<h4>Memasukkan Video</h4>
		</div>
		
			<p> Anda dapat memasukkan video pada topik sebagai konten tambahan yang bersumber dari YouTube.</p>
			<p>Langkah memasukkan video:</p>
			<ul>
				<ol>
				<li>Copy link URL video.</li>
				<li>Klik ikon <strong>"Insert Media"</strong> pada text editor.</li>
					<ul class="pt-2">
						Contoh link:
						<ul>
							
							<li>http://www.youtube.com/embed/1FAnrYu7LCM</li>
						</ul>
					</ul>
				<li class="pt-3">Paste link URL video yang telah dicopy pada box source.</li>
				<li>Apabila ingin mengatur dimensi video dapat diatur pada box dimensions</li>
				<li>Klik <strong>"OK"</strong></li>
				</ol>
			</ul>

	  </div>
      <!-- <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div> -->
    </div>
  </div>
</div>
	
<style>
	#navbarsExample08.collapse.show, #navbarsExample08.collapsing {
		display: block!important;
	}
	
</style>

<!-- nav-pill -->
<script>
        $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
        var id = $(e.target).attr("href");
        localStorage.setItem('selectedTab', id)
        });

        var selectedTab = localStorage.getItem('selectedTab');
        if(selectedTab != null){
            $('a[data-toggle="pill"][href="' + selectedTab + '"]').tab('show');
        }
    </script>
<!-- end -->