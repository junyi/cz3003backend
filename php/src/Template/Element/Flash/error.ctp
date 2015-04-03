<script>
	$(window).load(function(){
		$.notify({
			// options
			message: <?= '"'.h($message).'"' ?>
		},{
			// settings
			type: 'error',
			delay: '2000',
			placement: {
				from: "top",
				align: "center"
			},
			animate: {
				enter: 'animated fadeInDown',
				exit: 'animated fadeOutUp'
			},
		});
	});
	
</script>