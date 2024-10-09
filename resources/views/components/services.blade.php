<div id="services-section">

    <div class="p-5 mb-4 bg-body-tertiary rounded-3">

        <h4 class="display-5 fw-bold">Seja Bem vindo!</h4>

        <p class="col-md-8 fs-4">Para começar escolha os serviços</p>

            <div class="form-group mt-3">

                <select class="form-control form-control-lg selectize" name="services[]" id="services" multiple>
                    <option value="">Escolha um serviço</option>

                    @foreach($services as $service)

                    <option value="{{ $service->id }}">{{ $service->description }}</option>

                    @endforeach

                </select>


            </div>


            @if(count($users) > 1)

            <div class="form-group">
                <select class="form-control form-control-lg selectize" name="professional" id="professional">
                    <option value="">Escolha o profissional</option>

                    @foreach($users as $user)
                    
                    <option value="{{ $user->id }}">{{ $user->name }}</option>

                    @endforeach
                </select>

            </div>

            @else

            <input type="hidden"  name="professional" id="professional" value="{{ $users[0]->id }}">

            @endif

            <div class="form-group form-floating">
                <input class="form-control date form-control-lg" type="date" name="date" id="date" />
                <label for="date">Escolha uma data</label>

            </div>

            <div class="form-group mb-5 mt-5 text-center">
                <button class="btn btn-lg btn-outline-dark">próximo

                    <!-- <i class="fas fa-chevron-right"></i> -->

                </button>
            </div>


    </div>


    <!-- <div class="form-group text-center mb-3">
        <h4>O que gostaria de fazer?</h4>
    </div> -->


</div>