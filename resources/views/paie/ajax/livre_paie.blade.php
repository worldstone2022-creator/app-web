@extends('layouts.app')

@push('datatable-styles')
    @include('sections.datatable_css')
@endpush

@php
$viewEmployeeTasks = user()->permission('view_employee_tasks');
$viewTickets = user()->permission('view_tickets');
$viewEmployeeProjects = user()->permission('view_employee_projects');
$viewEmployeeTimelogs = user()->permission('view_employee_timelogs');
$manageEmergencyContact = user()->permission('manage_emergency_contact');
$manageRolePermissionSetting = user()->permission('manage_role_permission_setting');
$manageShiftPermission = user()->permission('view_shift_roster');

@endphp
<style type="text/css">
    table.dataTable tbody tr.s-titre{
        background-color: #4c4c4c;
        color: #fff;
        font-weight: bold;
    }
    table.dataTable tbody tr.s-titre td{
        color: #fff;
        font-weight: bold;
    }
    table.dataTable tr.trait-top td{
        border-top: solid 1px #ccc;
    }
    table.dataTable tr.trait-bottom td{
        border-bottom: solid 1px #ccc;
    }
    table.dataTable tbody tr.footer{
        background-color: #000;
        color: #fff;
        font-weight: bold;
    }
    table.dataTable tbody tr.footer td{
        color: #fff;
        font-weight: bold;
        font-style: italic;
    }
    .table thead th:first-child, 
    .table tbody td:first-child,  
    .table thead th, 
    .table tbody td,
    table.dataTable thead th,
    table.dataTable thead td{
        border-right: solid 1px;
    }
    .table thead th:last-child, 
    .table tbody td:last-child{
        border-right: 0px;
    }
</style>


@section('content')
<div class="tw-p-2">
    <x-filters.filter-box>
        <form action="route('paieLivre.index')" method="GET">
           <!-- DATE START -->
            <div class="select-box d-flex pr-2 border-right-grey border-right-grey-sm-0">
                <p class="mb-0 pr-3 f-14 text-dark-grey d-flex align-items-center">@lang('app.date')</p>
                <div class="select-status d-flex">
                    <input type="text" class="form-control  date-picker height-35 f-14" placeholder="Selectionner Date" name="daterange" id="datepicker">
                </div>
            </div>
            <!-- DATE END -->

           
           <button type="submit" class="btn-primary rounded f-14 p-2 btn-xs"> <i class="fa fa-search"></i> @lang('app.search')</button>

        </form>
    </x-filters.filter-box>

<link rel="stylesheet" href="{{ asset('vendor/css/tagify.css') }}">

<div class="row add-client bg-white rounded">
    <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
      LIVRE PAIE MENSUEL <strong>({{$month }} {{$year}})</strong></h4>
  <div class="col-md-12">
  
    
  </div>
</div>

<!-- CONTENT WRAPPER START -->
<div class="tw-p-2 quentin-9-08_2025">
    <!-- Add Task Export Buttons Start -->

    <div class="d-flex justify-content-between action-bar">

        <div id="table-actions" class="d-block d-lg-flex align-items-center">
            

            {{--@if ($addDesignationPermission == 'all' || $addDesignationPermission == 'added')
            @if ($viewDesignationPermission == 'all')--}}
            {{--<x-forms.button-secondary class="mr-3 mb-2 mb-lg-0" icon="plus" id="salaireAVS">
                @lang('app.add') une demande d'@lang('app.avs')
            </x-forms.button-secondary>--}}
            {{--@endif
            @endif--}}

            
            
            
        </div>

        <x-datatable.actions>
            <div class="select-status mr-3 pl-3">
                <select name="action_type" class="form-control select-picker" id="quick-action-type" disabled>
                    <option value="">@lang('app.selectAction')</option>
                    <option value="change-status">@lang('modules.tasks.changeStatus')</option>
                    <option value="delete">@lang('app.delete')</option>
                </select>
            </div>
            <div class="select-status mr-3 d-none quick-action-field" id="change-status-action">
                <select name="status" class="form-control select-picker">
                    <option value="deactive">@lang('app.inactive')</option>
                    <option value="active">@lang('app.active')</option>
                </select>
            </div>
        </x-datatable.actions>

    </div>
    <!-- Add Task Export Buttons End -->
    <!-- Task Box Start -->


    <div class="d-flex flex-column w-tables rounded mt-3 bg-white">
        <div class="dataTables_wrapper dt-bootstrap4 no-footer">
            <div class="row">
                <div class="col-sm-12">
                    @if($paieLivre)
                    <table class="table table-hover border-0 w-100 dataTable no-footer" headType="thead-light">
                        <thead>
                            <tr>
                                <th class="">Rubrique</th>
                                @foreach($paieLivre as $item)
                                    <th class=""> {{$item['bulletin']->employee_id}}<br>{{$item['bulletin']->name. ' '.$item['bulletin']->lastname}}</th>
                                @endforeach
                                <th class="">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Nombre Jour</td>
                                @foreach($paieLivre as $key)
                                    <td>{{$key['bulletin']->nbreJour}}</td>
                                @endforeach
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Salaire de base</td>
                                <?php $totalSalBase=0; ?>
                                @foreach($paieLivre as $key)
                                    <td>{{number_format($key['bulletin']->salaire_base, 0, ',', ' ')}}</td>
                                    <?php $totalSalBase=$totalSalBase+$key['bulletin']->salaire_base; ?>
                                @endforeach
                                <td>{{number_format($totalSalBase, 0, ',', ' ')}}</td>
                            </tr>
                            <tr>
                                <td>Part IGR</td>
                                <?php $totalIGR=0; ?>
                                @foreach($paieLivre as $key)
                                    <td>{{number_format($key['bulletin']->part_IGR, 0, ',', ' ')}}</td>
                                    <?php $totalIGR=$totalIGR+$key['bulletin']->part_IGR; ?>
                                @endforeach
                                <td>{{number_format($totalIGR, 0, ',', ' ')}}</td>
                            </tr>
                            @foreach ($paieLivre[0]['prime'] as $prime)
                                @if($prime->type_prime=="Imposable")
                                    <tr>
                                        <?php $totalPrime=0; ?>
                                        <td>{{$prime->libelle_prime}}</td>
                                        @foreach($paieLivre as $key)
                                            <?php 
                                                $value=$salairePrime->where('bulletin_id', $key['bulletin']->id)->where('prime_id', $prime->prime_id)->first()->gain;
                                                $totalPrime=$totalPrime+$value;
                                            ?>
                                            @if($value )
                                                <td>{{number_format($value, 0, ',', ' ')}}</td>
                                            @else
                                                <td>---</td>
                                            @endif
                                            
                                        @endforeach
                                        <td>{{number_format($totalPrime, 0, ',', ' ')}}</td>
                                    </tr>
                                @endif
                            @endforeach
                            <tr class="s-titre">
                                <?php $totalButImposable=0; ?>
                                <td>Total brut imposable</td>
                                @foreach($paieLivre as $key)
                                    <td>{{number_format($key['bulletin']->total_imposable, 0, ',', ' ')}}</td>
                                    <?php $totalButImposable=$totalButImposable+$key['bulletin']->total_imposable; ?>
                                @endforeach
                                <td>{{number_format($totalButImposable, 0, ',', ' ')}}</td>
                            </tr>
                            @foreach ($paieLivre[0]['taxe'] as $taxe)

                                <tr>
                                    @php
                                        $colDisplayed = false;
                                        $totalTaxe=0; 
                                    @endphp
                                    @foreach($paieLivre as $key)
                                        <?php 
                                            $value=$salaireTaxe->where('bulletin_id', $key['bulletin']->id)->where('taxe_id', $taxe->taxe_id)->first()->retenu_salarial;
                                        ?>
                                        @if($value)
                                            @if(!$colDisplayed)
                                                <td>{{$taxe->libelle_taxe}}</td>
                                                @php
                                                    $colDisplayed = true;
                                                @endphp
                                            @endif
                                        @endif
                                    @endforeach
                                    
                                    @foreach($paieLivre as $key)
                                        <?php 
                                            $value=$salaireTaxe->where('bulletin_id', $key['bulletin']->id)->where('taxe_id', $taxe->taxe_id)->first()->retenu_salarial;
                                            $totalTaxe=$totalTaxe+$value;
                                        ?>
                                        @if($value )
                                            <td>{{number_format($value, 0, ',', ' ')}}</td>
                                        @endif
                                    @endforeach

                                    @php
                                        $colDisplayed = false;
                                    @endphp
                                    @foreach($paieLivre as $key)
                                        <?php 
                                            $value=$salaireTaxe->where('bulletin_id', $key['bulletin']->id)->where('taxe_id', $taxe->taxe_id)->first()->retenu_salarial;
                                        ?>
                                        @if($value)
                                            @if(!$colDisplayed)
                                                <td>{{number_format($totalTaxe, 0, ',', ' ')}}</td>
                                                @php
                                                    $colDisplayed = true;
                                                @endphp
                                            @endif
                                        @endif
                                    @endforeach
                                        

                                </tr>
                            @endforeach
                            <tr class="s-titre">
                                <?php $totalCotisationSalarie=0; ?>
                                <td>Total cotisation salariés</td>
                                @foreach($paieLivre as $key)
                                    <td>{{number_format($key['bulletin']->total_retenu_salarial, 0, ',', ' ')}}</td>
                                    <?php $totalCotisationSalarie=$totalCotisationSalarie+$key['bulletin']->total_retenu_salarial; ?>
                                @endforeach
                                <td>{{number_format($totalCotisationSalarie, 0, ',', ' ')}}</td>
                            </tr>
                            @foreach ($paieLivre[0]['taxe'] as $taxe)

                                <tr>
                                    @php
                                        $colDisplayed = false;
                                        $totalTaxeEmployeur=0; 
                                    @endphp
                                    @foreach($paieLivre as $key)
                                        <?php 
                                            $value=$salaireTaxe->where('bulletin_id', $key['bulletin']->id)->where('taxe_id', $taxe->taxe_id)->first()->retenu_patronal;
                                        ?>
                                        @if($value)
                                            @if(!$colDisplayed)
                                                <td>{{$taxe->libelle_taxe}}</td>
                                                @php
                                                    $colDisplayed = true;
                                                @endphp
                                            @endif
                                        @endif
                                    @endforeach
                                    
                                    @foreach($paieLivre as $key)
                                        <?php 
                                            $value=$salaireTaxe->where('bulletin_id', $key['bulletin']->id)->where('taxe_id', $taxe->taxe_id)->first()->retenu_patronal;
                                            $totalTaxeEmployeur=$totalTaxeEmployeur+$value;
                                        ?>
                                        @if($value )
                                            <td>{{number_format($value, 0, ',', ' ')}}</td>
                                        @endif
                                    @endforeach
                                    @php
                                        $colDisplayed = false;
                                    @endphp
                                    @foreach($paieLivre as $key)
                                        <?php 
                                            $value=$salaireTaxe->where('bulletin_id', $key['bulletin']->id)->where('taxe_id', $taxe->taxe_id)->first()->retenu_patronal;
                                        ?>
                                        @if($value)
                                            @if(!$colDisplayed)
                                                <td>{{number_format($totalTaxeEmployeur, 0, ',', ' ')}}</td>
                                                @php
                                                    $colDisplayed = true;
                                                @endphp
                                            @endif
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach

                            <tr class="s-titre">
                                <?php $totalCotisationEmployeur=0; ?>
                                <td>Total cotisation employeur</td>
                                @foreach($paieLivre as $key)
                                    <td>{{number_format($key['bulletin']->total_retenu_patronal, 0, ',', ' ')}}</td>
                                    <?php $totalCotisationEmployeur=$totalCotisationEmployeur+$key['bulletin']->total_retenu_patronal; ?>
                                @endforeach
                                <td>{{number_format($totalCotisationEmployeur, 0, ',', ' ')}}</td>
                            </tr>

                            <tr>
                                <td>Autre retenue</td>
                                <?php $totalAutreRetenue=0; ?>
                                @foreach($paieLivre as $key)
                                    <td>{{number_format($key['bulletin']->autre_retenu, 0, ',', ' ')}}</td>
                                    <?php $totalAutreRetenue=$totalAutreRetenue+$key['bulletin']->autre_retenu; ?>
                                @endforeach
                                <td>{{number_format($totalAutreRetenue, 0, ',', ' ')}}</td>
                            </tr>
                            <tr class="trait-bottom">
                                <?php $totalAVS=0; ?>
                                <td>Avance</td>
                                @foreach($paieLivre as $key)
                                    <td>{{number_format($key['bulletin']->avs, 0, ',', ' ')}}</td>
                                    <?php $totalAVS=$totalAVS+$key['bulletin']->avs; ?>
                                @endforeach
                                <td>{{number_format($totalAVS, 0, ',', ' ')}}</td>
                            </tr>
                            @foreach ($paieLivre[0]['prime'] as $prime)
                                @if($prime->type_prime=="Non imposable")
                                    <tr>
                                        <?php $totalPrimeNI=0; ?>
                                        <td>{{$prime->libelle_prime}}</td>
                                        @foreach($paieLivre as $key)
                                            <?php 
                                                $value=$salairePrime->where('bulletin_id', $key['bulletin']->id)->where('prime_id', $prime->prime_id)->first()->gain;
                                                $totalPrimeNI=$totalPrimeNI+$value;
                                            ?>
                                            @if($value )
                                                <td>{{number_format($value, 0, ',', ' ')}}</td>
                                            @else
                                                <td>---</td>
                                            @endif
                                            
                                        @endforeach
                                        <td>{{number_format($totalPrimeNI, 0, ',', ' ')}}</td>
                                    </tr>
                                @endif
                            @endforeach
                            <tr class="trait-top">
                                <?php $totalButNonImposable=0; ?>
                                <td>Total brut</td>
                                @foreach($paieLivre as $key)
                                    <td>{{number_format($key['bulletin']->total_brut_general, 0, ',', ' ')}}</td>
                                    <?php $totalButNonImposable=$totalButNonImposable+$key['bulletin']->total_brut_general; ?>
                                @endforeach
                                <td>{{number_format($totalButNonImposable, 0, ',', ' ')}}</td>
                            </tr>
                            <tr class="footer">
                                <?php $totalNetaPayer=0; ?>
                                <td>Net à payer</td>
                                @foreach($paieLivre as $key)
                                    <td>{{number_format($key['bulletin']->net_a_payer, 0, ',', ' ')}}</td>
                                    <?php $totalNetaPayer=$totalNetaPayer+$key['bulletin']->net_a_payer; ?>
                                @endforeach
                                <td>{{number_format($totalNetaPayer, 0, ',', ' ')}}</td>
                            </tr>
                        </tbody>
                    </table>
                    @else
                        <div class="alert alert-info text-center" role="alert">Aucune donnée pour la période choisie</div>
                    @endif
                </div>
            </div>
            
        </div>

                   <?php //dd($paieLivre); ?>   
    </div>
    <!-- Task Box End -->
          
      
@include('sections.datatable2_js')
<script src="{{ asset('vendor/jquery/tagify.min.js') }}"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="//code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
    $('#datepicker').focus(function() {
        $(".ui-datepicker-calendar").hide();
        $(".ui-datepicker-current").hide();
    }).on('click', function() {
        $(".ui-datepicker-calendar").hide();
        $(".ui-datepicker-current").hide();
    });
  $(function() {
        $.datepicker.regional['fr'] = {
            closeText: 'Valider',
            prevText: '&#x3c;Préc',
            nextText: 'Suiv&#x3e;',
            currentText: 'Courant',
            monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
              'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
            ],
            monthNamesShort: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun',
              'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'
            ],
            dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
            dayNamesShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
            dayNamesMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
            weekHeader: 'Sm',
            dateFormat: 'MM yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
  
        // Configuration du datepicker
        var options = {
            dateFormat: 'MM yy', // Format d'affichage
            changeMonth: true, // Option pour sélectionner le mois
            changeYear: true, // Option pour sélectionner l'année
            showButtonPanel: true, // Afficher les boutons "Today" et "Done"
            defaultDate: "-1m", // Sélection par défaut : le mois précédent

            onClose: function(dateText, inst) {
                  // Récupérer la date sélectionnée
                  var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                  var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                  // Afficher la date sélectionnée dans le champ de saisie
                  $("#datepicker").val($.datepicker.formatDate('MM yy', new Date(year, month, 1)));
                  //ajouter ici l'ajax qui fera la requette
                 
            }
        };
    
        // Initialiser le datepicker avec la langue française
        $.datepicker.setDefaults($.datepicker.regional['fr']);
        // Initialiser le datepicker avec la date par défaut
        //$("#datepicker").datepicker(options).datepicker('setDate', defaultDate);
        $("#datepicker").datepicker(options);
      
        // Cacher la partie jour du calendrier
        $(".ui-datepicker-calendar").hide();

        // Mettre à jour le champ de saisie avec la date par défaut
        options.onClose.call($('#datepicker').get(0), null, { 
            selectedMonth: defaultDate.getMonth(), 
            selectedYear: defaultDate.getFullYear() 
        });
    });

   
</script>


@endsection


