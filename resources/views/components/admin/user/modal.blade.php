<div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form id="modal-form" autocomplete="off">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ $title ?? "Adicionar novo Usuário" }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert" role="alert"></div>
                        <input id="id" name="id" type="hidden">

                        @foreach($fields as $field)

                            @if($field['field'] == 'profile')

                                <div class="form-group">
                                    <label>{{ $field['label'] }}</label>
                                        <select  id="{{ $field['field'] }}" class="form-control" name="{{ $field['field'] }}" >
                                                
                                            <opiton >Selecione um Perfil</opiton>

                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" >{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                </div>

                            @else

                                <div class="form-group">
                                    <label>{{ $field['label'] }} {!! isset($field['required']) ? '<span class="required"> *</span>' : null  !!} </label>
                                    <input {{ in_array($field['field'], ['password', 're_password']) ? 'type=password' : null   }}  id="{{ $field['field'] }}" class="form-control" name="{{ $field['field'] }}">
                                </div>


                            @endif

                        @endforeach

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" id="save" class="btn btn-primary">Salvar</button>
                    </div>
                </div>
            </div>
    </div>
    </form>
</div>

<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">
        <form id="confirm-form" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Atenção!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- <div class="alert" role="alert"></div> -->
                    <input id="user-id" type="hidden">

                    <p>Deseja excluir esse registro?</p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" id="delete-confirm" class="btn btn-danger">Confirmar</button>
                </div>
            </div>
        </form>
    </div>

</div>


<button title="Adicionar Usu;ário" class="btn btn-success btn-floating add btn-lg" type="button" data-toggle="modal" data-type="insert" data-target="#exampleModal">
<i class="fas fa-plus"></i>
</button>

</div>