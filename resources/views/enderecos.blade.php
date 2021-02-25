@extends('templates.template')
@section('content')

    <div class="col-12 mt-3">
        <div class="card shadow-sm border-0  mb-3">
            <div class="container">
                <h1 class=" display-1 text-dark text-center font-weight-bold">Calculador de Rota</h1>
            </div>
            <div class="text-center  container mt-8 " style="width: 400px;">
                    <button class="btn btn-secondary btn-lg btn-block" data-toggle="modal" data-target="#exampleModal">Adicionar Endereco</button>
            </div>
            <div class="card-body">
                <table class="table table-striped table-dark text-center">
                    <tr>
                        <th>Numero</th>
                        <th>Logradouro</th>
                        <th>Bairro</th>
                        <th>Cidade</th>
                        <th>Estado</th>
                    </tr>
                    @foreach($rotas as $item)
                        <tr>
                            <td>{{$item->numero}}</td>
                            <td>{{$item->logradouro}}</td>
                            <td>{{$item->bairro}}</td>
                            <td>{{$item->cidade}}</td>
                            <td>{{$item->estado}}</td>                       
                        </tr>
                        @endforeach
                        
                </table>
                @if(count($rotas) > 1)
                <div class="text-center  container mt-8 mb-4 " style="width: 200px;">
                    <a href="/enderecos/calcula">
                        <button class="btn btn-info btn-sm btn-block">Calcular Rota</button>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Endereço para cálculo de rota</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="/enderecos/store" method="post">
              @csrf
                <div class="form-group">
                  <label for="logradouro" class="col-form-label">Logradouro:</label>
                  <input type="text" class="form-control" id="logradouro" name="logradouro" required>
                </div>
                <div class="form-group">
                  <label for="numero" class="col-form-label">Numero:</label>
                  <input type="number" class="form-control" id="numero" name="numero" required>
                </div>
                <div class="form-group">
                  <label for="bairro" class="col-form-label">Bairro:</label>
                  <input type="text" class="form-control" id="bairro" name="bairro" required>
                </div>
                <div class="form-group">
                    <label for="cidade" class="col-form-label">Cidade:</label>
                    <input type="text" class="form-control" id="ciadade" name="cidade" required>
                  </div>
                  <div class="form-group">
                    <label for="estado" class="col-form-label">Estado:</label>
                    <input type="text" class="form-control" id="estado" name="estado" required>
                  </div>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
            </form>
          </div>
        </div>
      </div>
    @if(isset($menor_rota))

    <div class="col-12 mt-5">
        <div class="card shadow-sm border-0  mb-3">
            <div class="container">
                <h1 class=" display-3 text-dark text-center font-weight-bold">Menor Rota</h1>
            </div>
            <div class="card-body">
                <table class="table table-striped table-dark text-center">
                    <tr>
                        <th>Rota</th>
                        <th>De</th>
                        <th>Para</th>
                        <th>Total</th>
                    </tr>
                    <?php for($i=0;$i<count($menor_rota)-1;$i++){?>
                        <tr>
                            <td>{{$i+1}}º rota</td>
                            <td>{{$menor_rota[$i][1]}}, {{$menor_rota[$i][0]}}, {{$menor_rota[$i][2]}}, {{$menor_rota[$i][3]}}</td>   
                            <td>{{$menor_rota[$i+1][1]}}, {{$menor_rota[$i+1][0]}}, {{$menor_rota[$i+1][2]}}, {{$menor_rota[$i+1][3]}}</td>  
                            <td>{{$menor_distancia[$i]}} metros</td>
                        </tr>
                       <?php } ?>
                       <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{$distancia_total}} metros</td>
                        </tr>
                </table>
            </div>
        </div>
    </div>
    @endif


@endsection