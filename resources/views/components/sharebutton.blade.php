<!-- Button trigger modal -->
<button type="button" title="Compartilha agenda" class="btn btn-primary btn-floating share btn-lg" data-toggle="modal" data-target="#shareModal">
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

        <div class="input-group mb-3">
          <input type="text" class="form-control" id="shareurl-field" value="{{$link}}" placeholder="" aria-label="" aria-describedby="basic-addon1">
        <div class="input-group-prepend">
        <button class="btn btn-outline-primary" id="copy-shareurl" type="button">Copiar</button>
        </div>
        </div>
        <!-- <div class="form-group">


        
          <label>Copie a url:</label>          
          <input id="shareurl-field" value="" class="form-control" >
          <button class="btn btn-success" id="copy-shareurl">Copiar</button>
        </div> -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
