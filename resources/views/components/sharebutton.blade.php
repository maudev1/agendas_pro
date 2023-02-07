<!-- Button trigger modal -->
<button type="button" title="Compartilha agenda" class="btn btn-primary btn-share btn-lg" data-toggle="modal" data-target="#shareModal">
<i class="fas fa-share-alt"></i></button>


<!-- Modal -->
<div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="shareModalLabel">Compartilhar Agenda</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label>Copie a url:</label>
        <input id="url-field" value="" class="form-control" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

@section('css')
<style>

button.btn-share{
    position: fixed;
    right: 20px;
    bottom: 20px;
    z-index: 1;


}

</style>
@stop