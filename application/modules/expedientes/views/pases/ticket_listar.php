<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Ticket
		</h1>
		<ol class="breadcrumb">
			<li><a href=""><i class="fa fa-home"></i> Inicio</a></li>
			<li><a href="expedientes/escritorio">Expedientes</a></li>
			<li><a href="expedientes/<?php echo $controlador; ?>"><?php echo ucfirst($controlador); ?></a></li>
			<li class="active"><?php echo ucfirst($metodo); ?></li>
		</ol>
	</section>
	<section class="content">
		<?php if (!empty($error)) : ?>
			<div class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-ban"></i> Error!</h4>
				<?php echo $error; ?>
			</div>
		<?php endif; ?>
		<?php if (!empty($message)) : ?>
			<div class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-check"></i> OK!</h4>
				<?php echo $message; ?>
			</div>
		<?php endif; ?>
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Listado de Tickets</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<?php echo $js_table;?>
						<?php echo $html_table;?>
					</div>
					<div class="box-footer">
						<!-- -->
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<!-- Modal -->
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Expedientes recibidos</h4>
      </div>
      <div class="modal-body">
          <ul class="list-group" id="list_detail">
            <li class="list-group-item">saradadfasf</li>
          </ul>
      </div>
    </div>
  </div>
</div>

<script>
    function show_detail_ticket(ticket_id, emitido){
        //expedientes/pases/detalle_ticket/$1
        var request = $.ajax({
            url: "expedientes/pases/detalle_ticket/"+ticket_id+"/"+emitido,
            method: "GET",
            data: {},
            dataType: "html"
          });

          request.done(function( json ) {
            var lista = $.parseJSON(json);
            
            var str_html = "";
            lista.forEach(function (item){
                str_html += '<li class="list-group-item">'+item.numero+'/'+item.ano+' - '+item.anexo+'</li>';
            })
            $("#list_detail").html(str_html);
            $('#modalDetail').modal('show')
          });

          request.fail(function( jqXHR, textStatus ) {
            alert( "Error!: " + textStatus );
          });
    }
</script>