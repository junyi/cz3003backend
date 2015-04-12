<script>
		$.notify({
			// options
			message: <?= '"'.h($message).'"' ?>
		},{
			// settings
			type: 'success',
			delay: '2000',
			timer: '100',
			placement: {
				from: "top",
				align: "center"
			},
			animate: {
				enter: 'animated fadeInDown',
				exit: 'animated fadeOutUp'
			}
		});
	
</script>