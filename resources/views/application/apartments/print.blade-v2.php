@extends('adminlte::page')
@section('adminlte_css_pre')
<style>
    @page {
        margin: 2cm;
    }
</style>
@endsection

@section('title', '- Dados de Consumo')

@section('content')
<div class="card ml-n4 border" style="margin-bottom: -75px;">
    <div class="d-flex flex-wrap justify-content-center">
        <img src="{{ asset('img/logo.png') }}" style="width: 500px;">
        <h2 class="w-100 text-center">Relatório de Consumo Individual de Água</h2>
    </div>
    <div class="card-header">
        <h3 class="card-title">Dados de Consumo</h3>
    </div>

    <form style="border: 4px solid #007bff">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between">
                <div class="col-6 form-group pr-2">
                    <label for="description">Imóvel</label>
                    <input type="text" class="form-control bg-light" id="description" name="description" value="Condomínio: {{ $apartment->block->complex['alias_name'] }} - Bloco: {{ $apartment->block['name'] }} - Apartamento: {{ $apartment->name }}" disabled>
                </div>

                <div class="col-6 form-group pl-2">
                    <label for="dealership">Concessionária</label>
                    <input type="text" class="form-control bg-light" id="dealership" name="dealership" value="{{ $reading->dealershipReading->dealership['name'] }}" disabled>
                </div>
            </div>

            <div class="d-flex flex-wrap justify-content-between">
                <div class="col-3 form-group pr-2">
                    <label for="month_ref">Mês de Referência</label>
                    <input type="text" class="form-control bg-light" id="month_ref" name="month_ref" value="{{ $reading->month_ref }}" disabled>
                </div>

                <div class="col-3 form-group px-2">
                    <label for="year_ref">Ano de Referência</label>
                    <input type="text" class="form-control bg-light" id="year_ref" name="year_ref" value="{{ $reading->year_ref }}" disabled>
                </div>

                <div class="col-3 form-group px-2">
                    <label for="reading_date">Data da Leitura</label>
                    <input type="text" class="form-control bg-light" id="reading_date" name="reading_date" value="{{ $reading->dealershipReading->reading_date }}" disabled>
                </div>

                <div class="col-3 form-group pl-2">
                    <label for="reading_date_next">Data da Próxima Leitura</label>
                    <input type="text" class="form-control bg-light" id="reading_date_next" name="reading_date_next" value="{{ $reading->dealershipReading->reading_date_next }}" disabled>
                </div>
            </div>

            <div class="d-flex flex-wrap justify-content-between">
                <div class="col-3 form-group pr-2">
                    <label for="dealership_consumption_tax_1">Limite da 1ª Faixa em
                        m<sup>3</sup></label>
                    <input type="text" class="form-control bg-light" id="dealership_consumption_tax_1" name="dealership_consumption_tax_1" value="{{ $reading->dealershipReading->dealership_consumption_tax_1 }}" disabled>
                </div>

                <div class="col-3 form-group px-2">
                    <label for="dealership_cost_tax_1">Custo da 1ª Faixa de Consumo</label>
                    <input type="text" class="form-control bg-light" id="dealership_cost_tax_1" placeholder="Valor em reais da 1ª Faixa de Consumo pela concessionária" name="dealership_cost_tax_1" value="{{ $reading->dealershipReading->dealership_cost_tax_1 }}" disabled>
                </div>

                <div class="col-3 form-group px-2">
                    <label for="dealership_consumption_tax_2">Base da 2ª Faixa em
                        m<sup>3</sup></label>
                    <input type="text" class="form-control bg-light" id="dealership_consumption_tax_2" name="dealership_consumption_tax_2" value="{{ $reading->dealershipReading->dealership_consumption_tax_2 }}" disabled>
                </div>

                <div class="col-3 form-group pl-2">
                    <label for="dealership_cost_tax_2">Custo da 2ª Faixa de Consumo</label>
                    <input type="text" class="form-control bg-light" id="dealership_cost_tax_2" name="dealership_cost_tax_2" value="{{ $reading->dealershipReading->dealership_cost_tax_2 }}" disabled>
                </div>
            </div>

            <h4 class="h5 text-muted mt-3">Dados do Condomínio</h4>
            <div class="d-flex flex-wrap justify-content-between">
                <div class="col-4 form-group pr-2">
                    <label for="dealership_consumption">Consumo do Condomínio em m<sup>3</sup></label>
                    <input type="text" class="form-control bg-light" id="dealership_consumption" name="dealership_consumption" value="{{ $reading->dealershipReading->dealership_consumption }}" disabled>
                </div>
                <div class="col-4 form-group px-2">
                    <label for="dealership_cost">Consumo do Condomínio em Reais</label>
                    <input type="text" class="form-control bg-light" id="dealership_cost" name="dealership_cost" value="{{ $reading->dealershipReading->dealership_cost }}" disabled>
                </div>
                <div class="col-4 form-group pl-2">
                    <label for="diff_consumption">Área Comum em m<sup>3</sup></label>
                    <input type="text" class="form-control bg-light" id="diff_consumption" name="diff_consumption" value="{{ $reading->dealershipReading->diff_consumption }}" disabled>
                </div>
            </div>

            {{-- Kite Car --}}
            @if ($reading->dealershipReading->kite_car == 'Sim')
            <div class="d-flex flex-wrap justify-content-start">
                <div class="col-4 form-group pr-2">
                    <label for="kite_car">Carro Pipa</label>
                    <input type="text" class="form-control bg-light" id="kite_car" name="kite_car" disabled value="{{ $reading->dealershipReading->kite_car }}" disabled>
                </div>

                <div class="col-4 form-group px-2">
                    <label for="dealership_consumption">m<sup>3</sup> recebidos</label>
                    <input type="text" class="form-control bg-light" id="kite_car_consumption" placeholder="Quantidade de m³" name="kite_car_consumption" value="{{ $reading->dealershipReading->kite_car_consumption }}" disabled>
                </div>

                <div class="col-4 form-group pl-2">
                    <label for="kite_car_tax">Valor do m<sup>3</sup></label>
                    <input type="text" class="form-control bg-light" id="kite_car_tax" placeholder="Quantidade em Reais" name="kite_car_tax" value="R$ {{ $reading->dealershipReading->kite_car_tax }}" disabled>
                </div>

                <div class="col-4 form-group pr-2">
                    <label for="kite_car_qtd">Qtd Caminhões</label>
                    <input type="text" class="form-control bg-light" id="kite_car_qtd" placeholder="Quantidade" name="kite_car_qtd" value="{{ $reading->dealershipReading->kite_car_qtd }}" disabled>
                </div>

                <div class="col-4 form-group px-2">
                    <label for="value_per_kite_car">Valor por Caminhão</label>
                    <input type="text" class="form-control bg-light" id="value_per_kite_car" name="value_per_kite_car" disabled value="{{ $reading->dealershipReading->value_per_kite_car }}">
                </div>

                <div class="col-4 form-group pl-2">
                    <label for="kite_car_total">Valor Total Carro Pipa</label>
                    <input type="text" class="form-control bg-light" id="kite_car_total" name="kite_car_total" disabled value="{{ $reading->dealershipReading->kite_car_total }}">
                </div>

            </div>
            @endif

            {{-- Totais --}}
            <div class="d-flex flex-wrap justify-content-start">
                <div class="col-3 form-group pr-2">
                    <label for="monthly_consumption">Consumo Unidades em m<sup>3</sup></label>
                    <input type="text" class="form-control bg-light" id="monthly_consumption" name="monthly_consumption" disabled value="{{ $reading->dealershipReading->monthly_consumption }}">
                </div>

                <div class="col-3 form-group px-2">
                    <label for="monthly_consumption">Conta Total</label>
                    <input type="text" class="form-control bg-light" id="monthly_consumption" name="monthly_consumption" disabled value="{{ $reading->dealershipReading->total_value }}">
                </div>

                <div class="col-3 form-group px-2">
                    <label for="consumption_value">Valor do Consumo</label>
                    <input type="text" class="form-control bg-light" id="consumption_value" name="consumption_value" disabled value="{{ $reading->dealershipReading->consumption_value }}">
                </div>

                <div class="col-3 form-group pl-2">
                    <label for="sewage_value">Valor do Esgoto</label>
                    <input type="text" class="form-control bg-light" id="sewage_value" name="sewage_value" disabled value="{{ $reading->dealershipReading->sewage_value }}">
                </div>
            </div>

            <div class="d-flex flex-wrap justify-content-start">
                @if ($reading->dealershipReading->kite_car == 'Sim')
                <div class="col-4 form-group pr-2">
                    <label for="kite_car_consumed_units">Consumo Carro Pipa das Unidades em
                        m<sup>3</sup></label>
                    <input type="text" class="form-control bg-light" id="kite_car_consumed_units" name="kite_car_consumed_units" disabled value="{{ $reading->dealershipReading->kite_car_consumed_units }}">
                </div>

                <div class="col-4 form-group px-2">
                    <label for="kite_car_cost_units">Valor Carro Pipa das Unidades</label>
                    <input type="text" class="form-control bg-light" id="kite_car_cost_units" name="kite_car_cost_units" disabled value="{{ $reading->dealershipReading->kite_car_cost_units }}">
                </div>

                <div class="col-4 form-group pl-2">
                    <label for="diff_cost">Área Comum</label>
                    <input type="text" class="form-control bg-light" id="diff_cost" name="diff_cost" disabled value="{{ $reading->dealershipReading->diff_cost }}">
                </div>
                @else
                <div class="col-4 form-group pr-2">
                    <label for="diff_cost">Área Comum</label>
                    <input type="text" class="form-control bg-light" id="diff_cost" name="diff_cost" disabled value="{{ $reading->dealershipReading->diff_cost }}">
                </div>
                @endif
            </div>

            <div class="d-flex flex-wrap justify-content-start">
                <div class="col-4 form-group pr-2">
                    <label for="diff_consumption">Diferença Real e Concessionária em m<sup>3</sup></label>
                    <input type="text" class="form-control bg-light" id="diff_consumption" name="diff_consumption" disabled value="{{ $reading->dealershipReading->diff_consumption }}">
                </div>

                < <div class="col-4 form-group px-2">
                    <label for="previous_billed_consumption">Consumo Faturado Mês Anterior em
                        m<sup>3</sup></label>
                    <input type="text" class="form-control bg-light" id="previous_billed_consumption" name="previous_billed_consumption" disabled value="{{ $reading->dealershipReading->previous_billed_consumption }}">
            </div>

            <div class="col-4 form-group pl-2">
                <label for="previous_monthly_consumption">Consumo Real Anterior em
                    m<sup>3</sup></label>
                <input type="text" class="form-control bg-light" id="previous_monthly_consumption" name="previous_monthly_consumption" disabled value="{{ $reading->dealershipReading->previous_monthly_consumption }}">
            </div>

        </div>

        <h4 class="h5 text-muted mt-3">Dados da Unidade</h4>
        <div class="d-flex flex-wrap justify-content-between">
            <div class="col-4 form-group pr-2">
                <label for="total_consumed">Consumo da Unidade em m<sup>3</sup></label>
                <input type="text" class="form-control bg-light" id="total_consumed" name="total_consumed" value="{{ $reading->consumed }}" disabled>
            </div>
            <div class="col-4 form-group px-2">
                <label for="consumed_cost">Valor de Consumo</label>
                <input type="text" class="form-control bg-light" id="consumed_cost" name="consumed_cost" value="{{ $reading->consumed_cost }}" disabled>
            </div>
            <div class="col-4 form-group pl-2">
                <label for="sewage_cost">Valor do Esgoto</label>
                <input type="text" class="form-control bg-light" id="sewage_cost" name="sewage_cost" value="{{ $reading->sewage_cost }}" disabled>
            </div>
        </div>

        @if ($reading->dealershipReading->kite_car == 'Sim')
        <div class="d-flex flex-wrap justify-content-start">
            <div class="col-4 form-group pr-2">
                <label for="kite_car_consumed">Consumo Carro Pipa em
                    m<sup>3</sup></label>
                <input type="text" class="form-control bg-light" id="kite_car_consumed" name="kite_car_consumed" value="{{ $reading->kite_car_consumed }}" disabled>
            </div>

            <div class="col-4 form-group px-2">
                <label for="kite_car_cost">Valor do Carro Pipa</label>
                <input type="text" class="form-control bg-light" id="kite_car_cost" name="kite_car_cost" value="{{ $reading->kite_car_cost }}" disabled>
            </div>

            <div class="col-4 form-group pl-2">
                <label for="partial">Rateio Proporcional</label>
                <input type="text" class="form-control bg-light" id="partial" name="partial" value="{{ $reading->partial }}" disabled>
            </div>

        </div>

        <div class="d-flex flex-wrap justify-content-start">
            <div class="col-4 form-group pr-2">
                <label for="total_consumed">Consumo Total da Unidade em m<sup>3</sup></label>
                <input type="text" class="form-control bg-light" id="total_consumed" name="total_consumed" value="{{ $reading->total_consumed }}" disabled>
            </div>

            <div class="col-4 form-group px-2">
                <label for="total_unit">Valor Total da Unidade</label>
                <input type="text" class="form-control bg-light" id="total_unit" name="total_unit" value="{{ $reading->total_unit }}" disabled>
            </div>
        </div>
        @else
        <div class="d-flex flex-wrap justify-content-start">
            <div class="col-4 form-group pr-2">
                <label for="partial">Rateio Proporcional</label>
                <input type="text" class="form-control bg-light" id="partial" name="partial" value="{{ $reading->partial }}" disabled>
            </div>

            <div class="col-4 form-group px-2">
                <label for="total_consumed">Consumo Total da Unidade em m<sup>3</sup></label>
                <input type="text" class="form-control bg-light" id="total_consumed" name="total_consumed" value="{{ $reading->total_consumed }}" disabled>
            </div>

            <div class="col-4 form-group pl-2">
                <label for="total_unit">Valor Total da Unidade</label>
                <input type="text" class="form-control bg-light" id="total_unit" name="total_unit" value="{{ $reading->total_unit }}" disabled>
            </div>
        </div>
        @endif

        <div class="border-bottom mb-4"></div>
        <h4 class="h5 text-muted mt-3">Detalhes por Medidor</h4>
        <div class="d-flex flex-wrap justify-content-between">
            @foreach ($readings as $reading)
            <div class="col-12 px-0">
                <h5>Medidor {{ $reading->meter['register'] }}
                    @if ($reading->meter['location'])
                    <span class="ml-2 badge badge-secondary">{{ $reading->meter['location'] }}</span>
                    @endif
                </h5>
            </div>

            <div class="col-3 form-group pr-2 d-flex flex-wrap justify-content-between">
                @if ($reading->cover_base64)
                <div class='col-12 align-self-center d-flex justify-content-center px-0'>
                    <img src="{{ url('storage/readings/' . $reading->cover_base64) }}" alt="Imagem da leitura" style="max-width: 100%; object-fit: cover; width: 100%; aspect-ratio: 1;" class="img-thumbnail d-block">
                </div>
                @elseif ($reading->cover)
                <div class='col-12 align-self-center d-flex justify-content-center px-0'>
                    <img src="{{ url('storage/readings/' . $reading->cover) }}" alt="Imagem da leitura" style="max-width: 100%; object-fit: cover; width: 100%; aspect-ratio: 1;" class="img-thumbnail d-block">
                </div>
                @elseif ($reading->cover)
                <div class='col-12 align-self-center d-flex justify-content-center px-0'>
                    <img src="{{ url('storage/readings/' . $reading->cover) }}" alt="Imagem da leitura" style="max-width: 100%; object-fit: cover; width: 100%; aspect-ratio: 1;" class="img-thumbnail d-block">
                </div>
                @elseif ($reading->url_cover)
                <div class='col-12 align-self-center d-flex justify-content-center px-0'>
                    <img src="{{ $reading->url_cover }}" alt="Imagem da leitura" style="max-width: 100%; object-fit: cover; width: 100%; aspect-ratio: 1;" class="img-thumbnail d-block">
                </div>
                @else
                <div class='col-12 align-self-center d-flex justify-content-center px-0'>
                    <img src="{{ asset('img/no-image.png') }}" alt="Sem Imagem de Leitura" style="max-width: 100%; object-fit: cover; width: 100%; aspect-ratio: 1;" class="img-thumbnail d-block">
                </div>
                @endif
            </div>
            <div class="col-9 form-group pl-2 d-flex flex-wrap justify-content-between align-content-center">

                <div class="col-6 form-group pr-2">
                    <label for="reading">Valor da Leitura em m<sup>3</sup></label>
                    <input type="text" class="form-control bg-light" id="reading" name="reading" value="{{ number_format(str_replace(',', '.', str_replace('.', '', $reading->reading)), 3, ',', '.') }}" disabled>
                </div>

                <div class="col-6 form-group pl-2">
                    <label for="volume_consumed">Consumo em m<sup>3</sup></label>
                    <input type="text" class="form-control bg-light" id="volume_consumed" name="volume_consumed" value="{{ number_format(str_replace(',', '.', str_replace('.', '', $reading->volume_consumed)), 3, ',', '.') }}" disabled>
                </div>

                <div class="col-6 form-group pr-2">
                    <label for="previous_volume_consumed">Consumo Anterior em
                        m<sup>3</sup></label>
                    <input type="text" class="form-control bg-light" id="previous_volume_consumed" name="previous_volume_consumed" value="{{ $reading->previous_volume_consumed != 'Inexistente' ? number_format(str_replace(',', '.', str_replace('.', '', $reading->previous_volume_consumed)), 3, ',', '.') : 'Inexistente' }}" disabled>
                </div>

                <div class="col-6 form-group pl-2">
                    <label for="comparative_percentage">Porcentagem Comparativa</label>
                    <input type="text" class="form-control {{ str_contains($reading->comparative_percentage, '-') ? 'bg-success' : ($reading->comparative_percentage == 'Inexistente' ? 'bg-light' : 'bg-warning') }}" id="comparative_percentage" name="comparative_percentage" value="{{ $reading->comparative_percentage }}" disabled>
                </div>
            </div>
            @endforeach
        </div>
</div>
</form>

</div>
@endsection

@section('custom_js')
<script>
    window.onload = function() {
        $(".main-footer").remove();
        window.print();
        setTimeout(function() {
            window.close();
        }, 1000);
    }
</script>
@endsection