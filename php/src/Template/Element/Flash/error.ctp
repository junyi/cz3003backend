<script>
	// $(window).load(function(){
		$.notify({
			// options
			message: <?= '"'.h($message).'"' ?>
		},{
			// settings
			type: 'danger',
			delay: '2000',
			timer: '100',
			placement: {
				from: "top",
				align: "center"
			},
			animate: {
				enter: 'animated fadeInDown',
				exit: 'animated fadeOutUp'
			},
		});
	// });
	
</script>