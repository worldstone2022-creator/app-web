@php
$addDesignationPermission = user()->permission('add_designation');
$addDepartmentPermission = user()->permission('add_department');

@endphp

<link rel="stylesheet" href="{{ asset('vendor/css/tagify.css') }}">
<style>
  .tagify_tags .height-35 {
      height: auto !important;
  }
      tbody, td, tfoot, th, thead, tr {
      border-color: inherit;
      border-style: solid;
      border-width: 0;
  }
  .table thead th {
    font-size: 13px;
    font-weight: 500;
    color: #000000;
    box-shadow: 0 1px 0 0 #f1f1f3;
  }
  .table thead th, .table th, .table td {
    border: 1px solid #dee2e6;
    padding: 6px;
  }
  .table thead th {
    background: #c1c1c1;
    vertical-align: middle;
  }
  .table .bold{
    font-weight: bold;
  }
  .table .footer{
    background: #161e29;
    color: #fff;
  }
  .table tr.footer td{
    color: #fff;
    font-size: 14px;
  }
  .paieForm .table [contenteditable=true]:focus::after {
    content: "Veuillez saisir une valeur";
    display: block;
    font-size: 11px;
    color: #99A5B5;
    position: absolute;
  }
  .paieForm .table [contenteditable=true]:hover::after {
    content: "Veuillez saisir une valeur";
    display: block;
    font-size: 11px;
    color: #99A5B5;
    position: absolute;
  }
</style>

<div class="row paieForm">
    <div class="col-sm-12">
        <x-form id="save-data-form">
          <input type="hidden" id="user_id" name="user_id" value="{{$employee->id}}">
          <input type="hidden" id="avs" name="avs">
          <input type="hidden" id="autre_retenu" name="autre_retenu">
          <input type="hidden" id="total_brut" name="total_brut">
          <input type="hidden" id="total_brut_general" name="total_brut_general">
          <input type="hidden" id="total_imposable" name="total_imposable">
          <input type="hidden" id="salaire_base" name="salaire_base">
          <input type="hidden" id="total_non_imposable" name="total_non_imposable">
          <input type="hidden" id="total_retenu_salarial" name="total_retenu_salarial">
          <input type="hidden" id="total_retenu_patronal" name="total_retenu_patronal">
          <input type="hidden" id="net_a_payer" name="net_a_payer">
            <div class="add-client bg-white rounded">
                <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
                    @lang('modules.paie.editBul') de <b>{{$employee->name}} {{$employee->lastname}} </b></h4>
              <div class="col-md-12">
                <div class="row pr-20 pl-20">
                    <div class="col-lg-12 col-xl-12">
                      <div class="row">
                        <div class="col-lg-1 col-md-4 pr-0">
                          <div class="form-group my-3" style="position: relative;">
                            <label class="f-14 text-dark-grey mb-12" data-label="true" for="dateDebutSalaire">Période Du:<sup class="f-14 mr-1">*</sup></label>
                            <input type="date" name="dateDebutSalaire" id="dateDebutSalaire" class="form-control height-35 f-14" value="{{$DateStart}}" required ="true" >
                          </div>

                        </div>
                        <div class="col-lg-1 col-md-4 pl-0">
                          <div class="form-group my-3" style="position: relative;">
                            
                            <label class="f-14 text-dark-grey mb-12" data-label="true" for="dateFinSalaire">Période Du:<sup class="f-14 mr-1">*</sup></label>
                            <input type="date" name="dateFinSalaire" id="dateFinSalaire" class="form-control height-35 f-14" value="{{$DateEnd}}" required ="true" >
                          </div>
                          
                        </div>
                        <div class="col-lg-2 col-md-4 pl-0">
                          <input type="hidden" id="idCategorie" name="idCategorie">
                          <input type="hidden" id="codeCategorie" name="codeCategorie">
                          <input type="hidden" id="annualLeaveID" name="annualLeaveID" value="{{$allocationConge ? $allocationConge->id: null;}}">
                          <input type="hidden" >
                          <input type="hidden" id="salaireCategorie" name="salaireCategorie" required="true" class="form-control height-35 f-14">
                          <x-forms.select fieldId="categorie" :fieldLabel="__('app.salCat')" fieldName="categorie" search="true" fieldRequired="true">
                            <option value="">--Choisir Salaire Catégoriel--</option>
                            @foreach ($salaireCategoriel as $item)
                              <option @if($salaire_categoriel) @if($salaire_categoriel->id==$item->id ) selected @endif @endif
                             value="{{ $item->id }}#{{$item->salaire_sc}}#{{$item->categorie_sc}}">{{ $item->categorie_sc }} -- {{$item->salaire_sc}} FCFA</option>
                            @endforeach
                          </x-forms.select>
                        </div>
                        <div class="col-lg-1 col-md-4 pl-0">
                          <div class="form-group my-3" style="position: relative;">
                            <label class="f-14 text-dark-grey mb-12" data-label="true" for="partIGR">Part IGR<sup class="f-14 mr-1">*</sup></label>
                            <input type="number" name="partIGR" id="partIGR" readonly="true" class="form-control height-35 f-14" placeholder="Part IGR" required="true" value="{{$employee->employeeDetail->part_IGR_employe }}">
                          </div>
                        </div>
                        <div class="col-lg-1 col-md-4 pl-0">
                          <div class="form-group my-3" style="position: relative;">
                            <label class="f-14 text-dark-grey mb-12" data-label="true" for="conges_mensuel_acquis">Congés acquis<sup class="f-14 mr-1">*</sup></label>
                            <input type="number" name="conges_mensuel_acquis" id="conges_mensuel_acquis" class="form-control height-35 f-14" placeholder="Congés mois acquis" required="true" value="2.5">
                          </div>
                        </div>
                        <div class="col-lg-2 col-md-4 pl-0">
                          <x-forms.datepicker fieldId="joining_date" :fieldLabel="__('modules.employees.joiningDate')"
                          fieldName="joining_date" :fieldPlaceholder="__('placeholders.date')" fieldRequired="true"
                          :fieldValue="$employee->employeeDetail->joining_date->format(global_setting()->date_format)" />
                        </div>
                        <div class="col-lg-1 col-md-4 pl-0">
                          <div class="form-group my-3" style="position: relative;">
                            <label class="f-14 text-dark-grey mb-12" data-label="true" for="ancienneteText">Ancienneté<sup class="f-14 mr-1">*</sup></label>
                            <input type="hidden" id="MonthAncien" name="MonthAncien" value="{{$totalMois}}">
                            <input type="text" name="ancienneteText" class="form-control height-35 f-14" readonly="true" id="ancienneteText" value="{{$anciennete}}">
                          </div>
                        </div>
                        <div class="col-lg-1 col-md-4 pl-0">
                          <x-forms.text fieldId="num_cnps" :fieldLabel="__('modules.employees.num_cnps')" 
                            :fieldValue="$employee->employeeDetail->num_cnps"
                              fieldName="num_cnps" fieldRequired="false" :fieldPlaceholder="__('placeholders.num_cnps')">
                          </x-forms.text>
                        </div>
                        <div class="col-lg-2 col-md-4 pl-0">
                          <x-forms.text fieldId="bank_account_num" :fieldLabel="__('modules.employees.bank_account_num')" :fieldValue="$employee->employeeDetail->bank_account_num" fieldName="bank_account_num"
                          fieldPlaceholder="N° de compte bancaire"></x-forms.text>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="pr-20 pl-20">
                  <x-table class="table table-bordered">
                    <thead>
                      <tr class="text-center">
                        <th rowspan="2" class="w-5">N°</th>
                        <th rowspan="2" class="w-25">DESIGNATION</th>
                        <th rowspan="2" class="w-10">BASE</th>
                        <th colspan="3" class="w-10 text-center">PART SALARIALE</th>
                        <th colspan="2" class="w-10 text-center">PART PATRONALE</th>
                      </tr>
                      <tr  class="text-center">
                        <th>Nbre/taux</th>
                        <th>GAINS</th>
                        <th>RETENUE</th>
                        <th>Nbre/taux</th>
                        <th>RETENUE</th>
                      </tr>
                    </thead>
                    
                    <tr>
                      <td class="text-center">0</td>
                      <td>Salaire catégoriel</td>
                      <td id="salaire_cat" contenteditable="true">0</td>
                      <td id="taux_salaire_cat" contenteditable="true">30</td>
                      <td id="gain_sal_cat">0</td>
                        <input type="hidden" value="0" id="gainSalCat" class="gain1 primeImposable">
                      <td>--</td>
                      <td>--</td>
                      <td>--</td>
                    </tr>
                    @forelse($salairePrime as $key=>$item)
                    <?php
                    $hide='';
                    $class="";
                    $classGratif="";
                      if ($item->base_prime) {
                        $base_prime=$item->base_prime;
                        $contenteditable='true';
                      }else{
                        if((strpos(strtolower($item->libelle_prime), "transport") !==false)&& !is_null($employee->employeeDetail)){
                          $base_prime=$employee->employeeDetail->prime_transport;
                          $contenteditable='false';
                        }elseif((strpos(strtolower($item->libelle_prime), "représentation") !==false)&& !is_null($employee->employeeDetail)){
                          $base_prime=$employee->employeeDetail->prime_representation;
                          $contenteditable='false';
                        }else{
                          $base_prime=0;
                          $contenteditable='true';
                        }
                      }
                      if((strpos(strtolower($item->libelle_prime), "ancienneté") !==false)&& !is_null($employee->employeeDetail)){
                          $base_prime=$primeAncienete;
                          $contenteditable='true';
                          $class='primeAncieneteAdd';
                      }
                      if((strpos(strtolower($item->libelle_prime), "gratification") !==false)&& !is_null($employee->employeeDetail)){
                          $contenteditable='true';
                          $classGratif='gratificationAdd';
                      }
                      if((strpos(strtolower($item->libelle_prime), "congé") !==false)&& !is_null($employee->employeeDetail)){
                          $contenteditable='true';
                          $classGratif='congeAdd';
                          if ($allocationConge) {
                            $nbreJour=$allocationConge->nbre_jour_conge;
                            $base_prime=$allocationConge->allocation;
                            //dd($allocationConge);
                            $item->nbreJTaux=30;
                          }else{
                            $hide='hide';
                          }
                      }

                        //dd($item);
                     ?>
                      <tr id="{{ $item->id }}" class="TablePrime {{ $hide }}">
                        <td class="text-center">{{ $item->id }}</td>
                        <td data-row-id="{{ $item->id }}">{{ ucwords($item->libelle_prime) }}</td>
                        <td data-row-id="{{ $item->id }}" class="base_prime {{$class}} {{$classGratif}}" id="base_prime{{ $item->id }}" contenteditable="{{$contenteditable}}">{{$base_prime}}</td>
                        <td data-row-id="{{ $item->id }}" class="taux_prime" id="taux_prime{{ $item->id }}" contenteditable="true">{{ $item->nbreJTaux }}</td>
                        <td data-row-id="{{ $item->id }}" class="gain_prime {{$class}} {{$classGratif}}" id="gain_prime{{ $item->id }}">0</td>
                        <input type="hidden" id="gain{{ $item->id }}" value="0" class="gain1 prime{{$item->type_prime }} {{$class}} {{$classGratif}}">
                        <td>--</td>
                        <td>--</td>
                        <td>--</td>   
                      </tr>
                    @empty
                      <tr>
                        <td colspan="3">@lang('messages.noRecordFound')</td>
                      </tr>
                    @endforelse

                    <tr class="bold text-center">
                      <td class="text-center">--</td>
                      <td class="text-right">Total brut</td>
                      <td>--</td>
                      <td>--</td>
                      <td id="totalBrut">0</td>
                      <td>--</td>
                      <td>--</td>
                      <td>--</td>
                    </tr>
                    <tr class="text-center">
                      <td class="text-center">--</td>
                      <td class="text-right">Brut Imposable</td>
                      <td>--</td>
                      <td>--</td>
                      <td id="totalImposable">0</td>
                      <td>--</td>
                      <td>--</td>
                      <td>--</td>
                    </tr>
                    <tr class="text-center">
                      <td class="text-center">--</td>
                      <td class="text-right">Brut Non Imposable</td>
                      <td>--</td>
                      <td>--</td>
                      <td id="totalNonImposable">0</td>
                      <td>--</td>
                      <td>--</td>
                      <td>--</td>
                    </tr>

                    @forelse($salaireTaxe as $row=>$item)
                      <?php 
                        $hide='';
                        if($item->code=='CRNS'){
                          $contenteditable='true';
                          $classGratif='congeAdd';
                          if ($allocationConge) {
                            $item->baseCalcule=$allocationConge->allocation;
                          }else{
                            $item->baseCalcule=0;
                            $hide='hide';
                          }
                      }
                      ?>

                      <tr id="row-{{ $item->id }}" class="TableTaxe {{ $hide }}">
                        <td class="text-center">{{ $item->id }}</td>
                        <td data-row-id="{{ $item->id }}" data-row-type="libelle_prime" data-row-value="{{$item->libelle_taxe}}" >{{ ucwords($item->libelle_taxe) }}</td>

                        <td data-row-id="{{ $item->id }}" class="base_taxe brutImposable @if($item->TypeApplicable=='Montant') baseFixe @elseif($item->TypeApplicable=='Taux') base{{ $item->baseCalcule }} @endif"  id="base_taxe{{ $item->id }}" contenteditable="true">@if($item->TypeApplicable=='Montant') {{$item->baseCalcule}} @endif</td>

                        <input type="hidden" value="{{$item->methodeCalcul}}" class="methodeCalcul" id="methodeCalcul{{ $item->id }}">
                        @if($item->code=='ITS')
                        <input type="hidden" value="" class="code{{$item->code}}" id="typeTaxe{{ $item->id }}">
                        @endif
                        <input type="hidden" value="{{ $item->baseCalcule }}" class="baseTaux" id="baseTaux{{ $item->id }}">
                        <input type="hidden" id="taxe{{ $item->id }}" value="0" class="gain2">

                        <td data-row-id="{{ $item->id }}" class="taux_salarial" id="taux_salarial{{ $item->id }}" contenteditable="true">{{ ucwords($item->taux_salarial) }}</td>
                        <td>--</td>
                        <td data-row-id="{{ $item->id }}" class="gain_taxe" id="gain_taxe{{ $item->id }}">0</td>
                        <td data-row-id="{{ $item->id }}" class="taux_patronal" id="taux_patronal{{ $item->id }}" contenteditable="true">{{ ucwords($item->taux_patronal) }}</td>
                        <td data-row-id="{{ $item->id }}" class="gain_taxePat" id="gain_taxePat{{ $item->id }}">0</td>   
                      </tr>
                    @empty
                      <tr>
                        <td colspan="3">@lang('messages.noRecordFound')</td>
                      </tr>
                    @endforelse
                    <tr class="text-center">
                      <td class="text-center">--</td>
                      <td class="text-right">Avance/Acompte</td>
                      <td style="text-align:left; color: darkred;">Reste à AVS FCFA</td>
                      <td style="text-align:left; color: darkred;" id="resteAVS">@if($salaireAVS) {{$salaireAVS->resteAVS}} @else 0 @endif </td>
                      <td>--</td>
                      <td contenteditable="true" id="avanceAcompte">0</td>
                      <td>--</td>
                      <td>--</td>
                    </tr>
                    <tr class="text-center">
                      <td class="text-center">--</td>
                      <td class="text-right">Autres retenues</td>
                      <td>--</td>
                      <td>--</td>
                      <td>--</td>
                      <td contenteditable="true" id="AutreRetenu">0</td>
                      <td>--</td>
                      <td>--</td>
                    </tr>
                    <tr class="bold text-center">
                      <td class="text-center"></td>
                      <td >Total</td>
                      <td>--</td>
                      <td>--</td>
                      <td id="TotalG">0</td>
                      <td id="total_retenu_Sal">0</td>
                      <td>--</td>
                      <td id="total_retenu_pat">0</td>
                    </tr>
                    <tr class="bold text-center footer">
                      <td class="text-center">#</td>
                      <td colspan="5">Net à Payer</td>
                      
                      <td colspan="2" id="netApayer">0</td>
                    </tr>
                  </x-table>
                </div>
                <x-form-actions>
                    <x-forms.button-primary id="save-form" class="mr-3" icon="check">Valider Bulletin
                    </x-forms.button-primary>
                    <x-forms.button-cancel :link="route('paie.index')" class="border-0">@lang('app.cancel')
                    </x-forms.button-cancel>
                    <span class="alert alert-danger f-14 p-2 ml-3 mb-0 error-msg" role="alert" style="display: none;">error</span>
                </x-form-actions>
              </div>
            </div>
        </x-form>

    </div>
</div>

<script src="{{ asset('vendor/jquery/tagify.min.js') }}"></script>
<!-- Inclusion de jQuery -->


<script>
    $(document).ready(function() {
      $('tr.hide').remove();
      $('#joining_date').prop('readonly', true);

        var value = $("#categorie").val();
        const valArray=value.split('#');
        var idCategorie=valArray[0];
        var salaireCategorie=valArray[1];
        var codeCategorie=valArray[2];
        $('#salaireCategorie').val(salaireCategorie);
        $('#idCategorie').val(idCategorie);
        $('#codeCategorie').val(codeCategorie);
        $('#salaire_base').val(salaireCategorie);
        $('#salaire_cat').html(salaireCategorie);
        var taux =$('#taux_salaire_cat').html();
        var date_actuelle = $('#dateFinSalaire').val();
        _calcul_gratification(salaireCategorie, date_actuelle)
        _calcul_gain_sal_cat(salaireCategorie, taux);

        $('.base_prime').each(function(i){
          //var gain = $(this).val(); 
          let id = $(this).data('row-id');
          let base_prime = $(this).html();
          let taux =$('#taux_prime'+id).html();
          _calcul_gain_prime(base_prime, taux, id);
        });

      $('[contenteditable=true]').focus(function() {
        var initialVal=$(this).html();
        if (parseInt(initialVal)==0) {
          $(this).html('');
        }
      });
      $('[contenteditable=true]').blur(function() {
        var initialVal=$(this).html();
        if (initialVal==''||parseInt(initialVal)==0) {
          $(this).html(0);
        }
      });
      

      function _calcul_anciennete(dateActuelle, dateEmbauche, salaireCategorie) {
        if (dateEmbauche!="" && dateActuelle!="") {
          var id=$("#user_id").val();
          var url = "{{ route('calculate_anciennete', ':id') }}";
          url = url.replace(':id', id);
          

          var token = "{{ csrf_token() }}";

          $.easyAjax({
              type: 'GET',
              url: url,
              blockUI: true,
              data: {
                'dateActuelle': dateActuelle,
                'dateEmbauche': dateEmbauche,
                'salaire_categoriel': salaireCategorie,
                '_token': token,
                '_method': 'GET'
              },
              success: function(response) {
                  if (response.status == "success") {
                    //console.log(response.primeAncienete);

                    $('.primeAncieneteAdd').html(response.primeAncienete);
                    $('.primeAncieneteAdd').val(response.primeAncienete);
                    $('#MonthAncien').val(response.totalMois);
                    $('#ancienneteText').val(response.anciennete);
                    _AllCalcul();

                  }
              }
          });
        }
      };

      function _calcul_gratification(salaireCategorie, date_actuelle) {
          var id=$("#user_id").val();
          var url = "{{ route('calculate_gratification', ':id') }}";
          url = url.replace(':id', id);
          var anciennete=$('#MonthAncien').val();

          var token = "{{ csrf_token() }}";

          $.easyAjax({
              type: 'GET',
              url: url,
              blockUI: true,
              data: {
                'anciennete': anciennete,
                'salaire_categoriel': salaireCategorie,
                'dateFin': date_actuelle,
                '_token': token,
                '_method': 'GET'
              },
              success: function(response) {
                    //console.log(response.gratification);
                  if (response.status == "success") {

                    $('.gratificationAdd').html(response.gratification);
                    $('.gratificationAdd').val(response.gratification);
                    
                    _AllCalcul();

                  }
              }
          });
      };
      
      $('body').on('change', '#dateFinSalaire', function() {
      // Code à exécuter lorsqu'une date est sélectionnée
        var date_actuelle = $(this).val();
        var date_ambauche=$('#joining_date').val();
        var value = $('#categorie').val();
        const valArray=value.split('#');
        var salaireCategorie=valArray[1];
        _calcul_gratification(salaireCategorie, date_actuelle);
        _calcul_anciennete(date_actuelle, date_ambauche, salaireCategorie);

    });


      /*$('#dateDebutSalaire').blur(function(e) {    
         
      }); */
      $('body').on('change', '#categorie', function() {
        var value = $(this).val();
        const valArray=value.split('#');
        var idCategorie=valArray[0];
        var salaireCategorie=valArray[1];
        var codeCategorie=valArray[2];
        $('#salaireCategorie').val(salaireCategorie);
        $('#idCategorie').val(idCategorie);
        $('#codeCategorie').val(codeCategorie);
        $('#salaire_base').val(salaireCategorie);
        $('#salaire_cat').html(salaireCategorie);
        var taux =$('#taux_salaire_cat').html();
        _calcul_gain_sal_cat(salaireCategorie, taux);
        var date_actuelle = $('#dateFinSalaire').val();
        var date_ambauche=$('#joining_date').val();
        _calcul_gratification(salaireCategorie, date_actuelle);
        _calcul_anciennete(date_actuelle, date_ambauche, salaireCategorie)
      });

      function _calcul_gain_sal_cat(base, taux) {
        var gain_sal_cat=Math.round((base*taux)/30);
        $('#gain_sal_cat').html(gain_sal_cat);
        $('#gainSalCat').val(gain_sal_cat);
        _AllCalcul();
      }

      $('#salaire_cat').blur(function() {
        let salaireCategorie = $(this).html();
        let taux =$('#taux_salaire_cat').html();
        $('#salaire_base').val(salaireCategorie);
        _calcul_gain_sal_cat(salaireCategorie, taux);
      });

      $('#taux_salaire_cat').blur(function() {
        let taux = $(this).html();
        let salaireCategorie=$('#salaire_cat').html();
        _calcul_gain_sal_cat(salaireCategorie, taux);
      });

      function _calcul_gain_prime(base, taux, id) {
        var gain_prime=Math.round((base*taux)/30);
        $('#gain_prime'+id).html(gain_prime);
        $('#gain'+id).val(gain_prime);
        _AllCalcul();
      }

      $('.base_prime').blur(function() {
        let id = $(this).data('row-id');
        let base_prime = $(this).html();
        let taux =$('#taux_prime'+id).html();
        _calcul_gain_prime(base_prime, taux, id);
      });

      $('.taux_prime').blur(function() {
        let id = $(this).data('row-id');
        let taux = $(this).html();
        let base_prime=$('#base_prime'+id).html();
        _calcul_gain_prime(base_prime, taux, id);
      });

      function _calculTotalBrut() {
        var total_brut=0;
        $('.gain1').each(function(i){
          var gain = $(this).val(); 
          total_brut=Math.round(Number(total_brut)+Number(gain));
        });
        $('#totalBrut').html(total_brut);
        $('#total_brut').val(total_brut);
        $('#TotalG').html(total_brut);
        $('#total_brut_general').val(total_brut);
      }

      function _calculTotalImposable() {
        var total=0;
        var T=0;
        $('.primeImposable').each(function(i){
          var gain = $(this).val(); 
          total=Math.round(Number(total)+Number(gain));
        });
        $('.brutImposable').each(function(i){
          let id = $(this).data('row-id');
          var baseTaux=$('#baseTaux'+id).val();
          baseCalcul=Math.round(Number(total)*Number(baseTaux)/100);
          $('.base'+baseTaux).html(baseCalcul);

          var methodeCalcul= $('#methodeCalcul'+id).val();
          if (methodeCalcul=="CN") {
            var NetImposable=baseCalcul;
            var cn=_calculCN(NetImposable);
            $('#gain_taxe'+id).html(cn);
          }
          if (methodeCalcul=="ITS") {
            var baseTaux=$('#baseTaux'+id).val();
            BrutImposable=baseCalcul;
            const its = Math.round(__calculerITS(BrutImposable));
            $('#gain_taxe'+id).html(its);
            $('#typeTaxe'+id).val(its);

          }
          /*if (methodeCalcul=="IGR") {
            var NetImposable=baseCalcul;
            var igr=_calculIGR(NetImposable);
            $('#gain_taxe'+id).html(igr);
          }*/

        });
        $('#totalImposable').html(total);
        $('#total_imposable').val(total);
        //$('.brutImposable').html(total);
        $('.gain2').val(total);
      }
      function __TrancheRevenu(salaireBrut) {
          const tranches = [
              { min: 0, max: 75000, taux: 0 },
              { min: 75001, max: 240000, taux: 16 },
              { min: 240001, max: 800000, taux: 21 },
              { min: 800001, max: 2400000, taux: 24 },
              { min: 2400001, max: 8000000, taux: 28 },
              { min: 8000001, max: Number.MAX_SAFE_INTEGER, taux: 32 },
          ];

          let trancheRevenu = 0;

          for (const tranche of tranches) {
              const { min, max, taux } = tranche;

              if (salaireBrut > max) {
                  const montantTranche = (max - min + 1) * (taux / 100);
                  trancheRevenu += montantTranche;
              } else {
                  const montantTranche = Math.max(0, (salaireBrut - min + 1) * (taux / 100));
                  trancheRevenu += montantTranche;
              }

              if (salaireBrut <= max) {
                  break;
              }
          }

          return trancheRevenu;
      }


      function __RCIF(part) {
          switch (part) {
              case 0:
                  return 0;
              case 1:
                  return 0;
              case 1.5:
                  return 5500;
              case 2:
                  return 11000;
              case 2.5:
                  return 16500;
              case 3:
                  return 22000;
              case 3.5:
                  return 27000;
              case 4:
                  return 33000;
              case 4.5:
                  return 38500;
              case 5:
                  return 44000;
              default:
                  return 44000; // Montant par défaut si la part dépasse 5
          }
      }

      function __calculerITS(salaireBrut) {

          var nombreDePart=parseFloat($('#partIGR').val());
          // Calcul de la tranche de revenu et du RCIF
          const trancheRevenu = __TrancheRevenu(salaireBrut);
          const RCIF = __RCIF(nombreDePart);

          // Calcul de l'ITS
          let ITS = trancheRevenu - RCIF;

          // Ajustement pour garantir que ITS est positif ou nul
          ITS = Math.max(0, ITS);
          //console.log('salaireBrut = ', salaireBrut);
          //console.log('Part = ', nombreDePart);
          //console.log('trancheRevenu = ', trancheRevenu);
          //console.log('RCIF = ', RCIF);
          return ITS;
      }

    






      function _calculCN(NetImposable) {
        var cn =0;
        var tranche1=0;
        var tranche2=0;
        var tranche3=0;
        var base=0;

        if (NetImposable>200000){
          base=NetImposable-200000;
          tranche3=(base)*10/100;
          NetImposable=NetImposable-base;
        }
        if (NetImposable>130000){
          base=NetImposable-130000;
          tranche2=(base)*5/100;
          NetImposable=NetImposable-base;
        }
        if (NetImposable>50000){
          base=NetImposable-50000;
          tranche1=(base)*1.5/100;
          NetImposable=NetImposable-base;
        }
        cn=Math.round(tranche1+tranche2+tranche3);
        return cn;
      }

      function _calculIGR(NetImposable) {
        var igr =0;
        var is=$('.codeIS').val();
        var cn=$('.codeCN').val();
        var R=0;
        var N=$('#partIGR').val();
        var Q=0;
        R=(NetImposable-(Number(is)+Number(cn)))*85/100;
        Q=R/N;
        if (Q<25000) {
          igr=0;
        }
        else if (Q<=45583) {
          igr=Math.round((R*10/110)-(2273*N));
        }
        else if (Q<=81583) {
          igr=Math.round((R*15/115)-(4076*N));
        }
        else if (Q<=126583) {
          igr=Math.round((R*20/120)-(7031*N));
        }
        else if (Q<=220333) {
          igr=Math.round((R*25/125)-(11250*N));
        }
        else if (Q<=389083) {
          igr=Math.round((R*35/135)-(24306 *N));
        }
        else if (Q<=842166) {
          igr=Math.round((R*45/145)-(44181 *N));
        }
        else if (Q>842166) {
          igr=Math.round((R*60/160)-(98633 *N));
        }
        
        return igr;
      }


      function _calculTotalNonImposable() {
        var total=0;
        $('.primeNon').each(function(i){
          var gain = $(this).val(); 
          total=Math.round(Number(total)+Number(gain));
        });
        $('#totalNonImposable').html(total);
        $('#total_non_imposable').val(total);
      }

      function _calcul_gain_salarial(base, taux, id) {
        var gain_taxe=Math.round((base*taux)/100);
        var methodeCalcul= $('#methodeCalcul'+id).val();
        /*if (methodeCalcul=="Normal") {
          $('#gain_taxe'+id).html(gain_taxe);
           
        }*/
        _calculSalariale();
        _calculNetAPayer();
      }

      $('.base_taxe').blur(function() {
        let id = $(this).data('row-id');
        let base_taxe = $(this).html();
        let taux =$('#taux_salarial'+id).html();
        _calcul_gain_salarial(base_taxe, taux, id);
      });

      $('.taux_salarial').blur(function() {
        let id = $(this).data('row-id');
        let taux = $(this).html();
        let base_taxe=$('#base_taxe'+id).html();
        _calcul_gain_salarial(base_taxe, taux, id);
      });

      function _calcul_gain_patronal(base, taux, id) {
        var gain_taxe=Math.round((base*taux)/100);
        $('#gain_taxePat'+id).html(gain_taxe);
        _calculPatronale();
        _calculNetAPayer();
      }

      $('.taux_patronal').blur(function() {
        let id = $(this).data('row-id');
        let taux = $(this).html();
        let base_taxe=$('#base_taxe'+id).html();
        _calcul_gain_patronal(base_taxe, taux, id);
      });

      $('#avanceAcompte').blur(function() {

        _calculSalariale();
        _calculNetAPayer();

      });

      $('#AutreRetenu').blur(function() {
        _calculSalariale();
        _calculNetAPayer();

      });

      $('.base_taxe').blur(function() {
        let id = $(this).data('row-id');
        let base_taxe = $(this).html();
        let taux =$('#taux_patronal'+id).html();
        _calcul_gain_patronal(base_taxe, taux, id);
      });

      function _calculSalariale() {
        var total_retenu_Sal=0;
        var total=0;
        var retenu_Sal=0;
        var its=0;
        let avs=$('#avanceAcompte').html();
        let resteAVSInitial = $('#resteAVS').html();
        var newReste=Math.round(Number(resteAVSInitial)-Number(avs));
        if (newReste<0) {
          $('.error-msg').html("La valeur de l'avance est supérieur au montant dû par l'employé. Veuillez saisir un montant inférieur ou égale à "+resteAVSInitial);
          $( ".error-msg" ).show( "fast" );
          $( "#avanceAcompte" ).focus();
          $('#save-form').prop('disabled', true);
          
        }else{
          $('.error-msg').html(" ");
          $( ".error-msg" ).hide();;
          $('#save-form').prop('disabled', false);
        }
        //console.log(newReste);

        let autreRetenu=$('#AutreRetenu').html();
        $('#avs').val(avs);
        $('#autre_retenu').val(autreRetenu);
        $('.primeImposable').each(function(i){
          var gain = $(this).val(); 
          total=Math.round(Number(total)+Number(gain));
        });
        $('.brutImposable').each(function(i){
          var base = $(this).html(); 
          let id = $(this).data('row-id');
          let taux=$('#taux_salarial'+id).html();
          
          var gain_taxe=Math.round((base*taux)/100);
          var methodeCalcul= $('#methodeCalcul'+id).val();
          if (methodeCalcul=="Normal") {
            $('#gain_taxe'+id).html(gain_taxe);
            $('#typeTaxe'+id).val(gain_taxe);
            retenu_Sal=gain_taxe;
            total_retenu_Sal=Math.round(Number(total_retenu_Sal)+Number(retenu_Sal));
          //console.log(retenu_Sal);
          }
          if (methodeCalcul=="ITS") {
            var baseTaux=$('#baseTaux'+id).val();
            BrutImposable=total;
            its = Math.round(__calculerITS(BrutImposable));
            $('#gain_taxe'+id).html(its);
          }
        });
            //console.log(its);
        //var cn=$('.codeCN').val();
        total_retenu_Sal=Math.round(Number(total_retenu_Sal)+Number(its)+Number(avs)+Number(autreRetenu));

        $('#total_retenu_Sal').html(total_retenu_Sal);
        $('#total_retenu_salarial').val(total_retenu_Sal);
        
      }

      function _calculPatronale() {
        var total_retenu_pat=0;
        $('.brutImposable').each(function(i){
          var base = $(this).html(); 
          let id = $(this).data('row-id');
          let taux=$('#taux_patronal'+id).html();
          var gain_taxe=Math.round((base*taux)/100);
          $('#gain_taxePat'+id).html(gain_taxe);
          //console.log(taux);
          total_retenu_pat=Math.round(Number(total_retenu_pat)+Number(gain_taxe));
        });
        $('#total_retenu_pat').html(total_retenu_pat);
        $('#total_retenu_patronal').val(total_retenu_pat);
        
      }

      function _calculNetAPayer() {
        let TotalG=$('#TotalG').html();
        let total_retenu_Sal=$('#total_retenu_Sal').html();
        var NetPayer=Math.round(Number(TotalG)-Number(total_retenu_Sal));
        /*console.log(nombre);
        let deuxDerniersChiffres = nombre % 100;
        if (deuxDerniersChiffres<50) {
          NetPayer=nombre-deuxDerniersChiffres+50;
        }else if(deuxDerniersChiffres>50){
          NetPayer=nombre-deuxDerniersChiffres+100;

        }*/
        $('#netApayer').html(NetPayer);
        $('#net_a_payer').val(NetPayer);
      }

      function _AllCalcul() {
        _calculTotalBrut();
        _calculTotalImposable();
        _calculTotalNonImposable();
        _calculSalariale();
        _calculPatronale();
        _calculNetAPayer();
      }
      datepicker('#joining_date', {
            position: 'bl',
            @if (!is_null($employee->employeeDetail->joining_date))
            dateSelected: new Date("{{ str_replace('-', '/', $employee->employeeDetail->joining_date) }}"),
            @endif
            ...datepickerConfig
        });
        /*datepicker('#dateDebutSalaire', {
            position: 'bl',
            ...datepickerConfig
        });*/
        /*datepicker('#dateFinSalaire', {
            position: 'bl',
            ...datepickerConfig
        });*/


        /*$('').click(function() {
            const url = "{{ route('employees.update', $employee->id) }}";

            $.easyAjax({
                url: url,
                container: '#save-data-form',
                type: "POST",
                disableButton: true,
                blockUI: true,
                buttonSelector: "#save-form",
                file: true,
                data: $('#save-data-form').serialize(),
                success: function(response) {
                    if (response.status == 'success') {
                        window.location.href = response.redirectUrl;
                    }
                }
            });
        });
        */



        function _tableauPrime(){
          var TableData = new Array();
            $('tr.TablePrime').each(function(row, tr){
            TableData[row]={
              "id" : $(tr).find('td:eq(0)').text()
              , "base" : $(tr).find('td:eq(2)').text()
              , "taux" : $(tr).find('td:eq(3)').text()
              , "gain" : $(tr).find('td:eq(4)').text()
            }
          }); 
          return TableData;
        }

        function _tableauTaxe(){
          var TableData = new Array();
            $('tr.TableTaxe').each(function(row, tr){
            TableData[row]={
              "id" : $(tr).find('td:eq(0)').text()
              , "base" : $(tr).find('td:eq(2)').text()
              , "taux_salarial" : $(tr).find('td:eq(3)').text()
              , "retenu_salarial" : $(tr).find('td:eq(5)').text()
              , "taux_patronal" : $(tr).find('td:eq(6)').text()
              , "retenu_patronal" : $(tr).find('td:eq(7)').text()
            }
          }); 
          return TableData;
        }

        $('#save-form').click(function() {
          var host=window.location.hostname;
          var TablePrime;
          TablePrime = _tableauPrime()
          TablePrime =  JSON.stringify(TablePrime);
          var TableTaxe;
          TableTaxe = _tableauTaxe()
          TableTaxe =  JSON.stringify(TableTaxe);
          const url = "{{ route('paie.store') }}";
          $.easyAjax({
                url: url,
                container: '#save-data-form',
                type: "POST",
                disableButton: true,
                blockUI: true,
                buttonSelector: "#save-form",
                file: true,
                //data: $('#save-data-form').serialize(),
                //data: $('#save-data-form').serialize(),
                data:{
                  //$('#save-data-form').serialize(),
                    'TableTaxe': TableTaxe,
                    'TablePrime': TablePrime,
                    '_method': 'POST'
                },
                success: function(response) {
                  if (response.status == 'success') {
                      var url = "{{ route('generate-bulletin-paie') }}?ref=";
                      var url2 = "{{ route('paie.index') }}";
                      if ($(MODAL_XL).hasClass('show')) {
                          $(MODAL_XL).hide();
                          //window.location.reload();
                          //window.location = url;
                          window.open(url+response.data, "_blank");
                          /*setTimeout(function(){
                            window.location.href = url2;
                          }, 100);*/

                      } else {
                        //window.location.reload();
                          window.open(url+response.data, "_blank");
                        /*setTimeout(function(){
                          window.location.href = url2;
                        }, 100);*/

                      }
                  }
                }
            });
 
        });

        $('#random_password').click(function() {
            const randPassword = Math.random().toString(36).substr(2, 8);

            $('#password').val(randPassword);
        });

        $('#designation-setting-edit').click(function() {
            const url = "{{ route('designations.create') }}";
            $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
            $.ajaxModal(MODAL_LG, url);
        })

        $('#department-setting').click(function() {
            const url = "{{ route('departments.create') }}";
            $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
            $.ajaxModal(MODAL_LG, url);
        });

        if ($('#last_date').length > 0) {
            datepicker('#last_date', {
                position: 'bl',
                @if ($employee->employeeDetail->last_date)
                    dateSelected: new Date("{{ str_replace('-', '/', $employee->employeeDetail->last_date) }}"),
                @endif
                ...datepickerConfig
            });
        }

        init(RIGHT_MODAL);
    });

    function checkboxChange(parentClass, id) {
        var checkedData = '';
        $('.' + parentClass).find("input[type= 'checkbox']:checked").each(function() {
            checkedData = (checkedData !== '') ? checkedData + ', ' + $(this).val() : $(this).val();
        });
        $('#' + id).val(checkedData);
    }

    $('.cropper').on('dropify.fileReady', function(e) {
            var inputId = $(this).find('input').attr('id');
            var url = "{{ route('cropper', ':element') }}";
            url = url.replace(':element', inputId);
            $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
            $.ajaxModal(MODAL_LG, url);
        });
</script>
