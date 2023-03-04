<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Meta;

class ServiceController extends Controller
{
    public function airBlock()
    {
        Meta::set('title', 'Acqua X do Brasil - Serviço: Bloqueador de Ar');
        Meta::set('description', 'O bloqueador de ar controla a vazão do ar, fazendo com que o hidrômetro não registre este ar como se fosse água.');
        Meta::set('robots', 'index,follow');
        Meta::set('image', asset('img/air-block-0.png'));
        Meta::set('canonical', env('APP_URL'));

        return view('site.services.air-block');
    }

    public function antiSuctionDevice()
    {
        Meta::set('title', 'Acqua X do Brasil - Serviço: Dispositivo Anti Sucção');
        Meta::set('description', 'O Dispositivo Anti Sucção é instalado na bomba da piscina e interrompe o processo de sucção da bomba em 2 segundos de forma automática.');
        Meta::set('robots', 'index,follow');
        Meta::set('image', asset('img/anti-suction-device-0.png'));
        Meta::set('canonical', env('APP_URL'));

        return view('site.services.anti-suction-device');
    }

    public function waterIndividualization()
    {
        Meta::set('title', 'Acqua X do Brasil - Serviço: Individualização de Hidrômetro');
        Meta::set('description', 'Realizamos obra de Individualização de Hidrômetro em prédios novos, também em antigos, com tecnologia de ponta e profissionais treinados, mão de obra própria e especializados na execução dos serviços.');
        Meta::set('robots', 'index,follow');
        Meta::set('image', asset('img/water-individualization-0.jpg'));
        Meta::set('canonical', env('APP_URL'));

        return view('site.services.water-individualization');
    }

    public function pumpMaintenance()
    {
        Meta::set('title', 'Acqua X do Brasil - Serviço: Manutenção de Bomba');
        Meta::set('description', 'Manutenção de Bomba, previne a queima do motor, além disso, diminui o gasto excessivo de energia causado pelo mal funcionamento dos equipamentos, Reduzindo assim os custos do condomínio.');
        Meta::set('robots', 'index,follow');
        Meta::set('image', asset('img/pump-maintenance-0.png'));
        Meta::set('canonical', env('APP_URL'));

        return view('site.services.pump-maintenance');
    }

    public function hydrometerMeasurement()
    {
        Meta::set('title', 'Acqua X do Brasil - Serviço: Medição de Hidrômetro');
        Meta::set('description', 'Realizamos medição de hidrômetro, leitura de hidrômetro por foto medição automática, medição visual e sistema de telemetria com medição diária ou mensal.');
        Meta::set('robots', 'index,follow');
        Meta::set('image', asset('img/hydrometer-measurement-0.jpg'));
        Meta::set('canonical', env('APP_URL'));

        return \view('site.services.hydrometer-measurement');
    }
}
