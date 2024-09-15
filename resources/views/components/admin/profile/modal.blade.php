    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form id="modal-form" autocomplete="off">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ $title ?? "Adicionar novo Perfil" }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- <div class="alert" role="alert"></div> -->
              

                        <x-admin.profile.modal-form :fields="$fields" :permissions="$permissions" ></x-admin.profile>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" id="save" class="btn btn-primary">Salvar</button>
                    </div>
                </div>
            </div>
    </div>
    </form>


    <button
        title="Adicionar Perfil"
        class="btn btn-success btn-floating btn-lg add"
        type="button"
        data-toggle="modal"
        data-type="insert"
        data-target="#exampleModal"><i class="fas fa-plus"></i></i>
    </button>