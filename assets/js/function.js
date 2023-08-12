function swalSuccess(judul, pesan) {
	Swal.fire({
		type: "success",
		title: judul,
		text: pesan
	}).then(result => {});
}
function swalError(judul, pesan) {
	setTimeout(function() {
		Swal.fire({
			type: "warning",
			title: judul,
			text: pesan
		}).then(result => {});
	}); 
}
