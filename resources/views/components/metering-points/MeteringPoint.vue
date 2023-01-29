<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h2 class="card-title">{{ $t('Metering point') }}</h2>
          <hr v-if="authUser && authUser!='no'" />
          <h4 class="card-title" v-if="authUser && authUser!='no'">{{ $t('Add metering point manually') }}</h4>
          <div class="card-tools" v-if="authUser && authUser!='no'">
            <div class="mb-3">
              <!-- Button "add new metering point". When clicked, it will call /showModal function (function to display modal pop up containing "add new metering point" form). -->
              <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#meteringPointModal"
                      @click.prevent="showModal"><i class="fas fa-bolt"></i> {{ $t('Add new metering point') }}
              </button>
            </div>
          </div>
          <hr />
          <h4 class="card-title">{{ $t('Get metering point from external source') }}</h4>
          <div class="card-tools">
            <form class="form">
              <div class="mb-3">
                <label class="form-check form-check-inline">{{ $t('Source') }}: </label>
                <div class="form-check form-check-inline">
                  <label class="form-check-label" for="source_datahub">
                    Datahub
                  </label>
                  <input class="form-check-input" type="radio" id="source" name="source_datahub" value="DATAHUB" v-model="source">
                </div>
                <div class="form-check form-check-inline">
                  <label class="form-check-label" for="source_ewii">
                    EWII
                  </label>
                  <input class="form-check-input" type="radio" id="source" name="source_ewii" value="EWII" v-model="source">
                </div>
                <div class="form-check form-check-inline" v-if="authUser && authUser!='no'">
                  <label class="form-check-label" for="source_poweruse"> POWERUSE
                  </label>
                  <input class="form-check-input" type="radio" id="source" name="source_poweruse" value="POWERUSE" v-model="source">
                </div>
              </div>
              <div class="mb-3" v-if="authUser.refresh_token==null || !authUser || authUser=='no'">
                  <label class="form-label form-control-lg" for="token" v-if="source=='DATAHUB'">{{ $t('Refresh token') }}</label>
                  <input class="col-xs-3 form-rounded" id="token" type="text" v-if="source=='DATAHUB'" v-model="token">
              </div>
              <div class="mb-3">
                  <label class="form-label form-control-lg" for="ewii_user_name" v-if="source=='EWII'">{{ $t('Ewii user name') }}</label>
                  <input class="col-xs-3 form-rounded" id="ewii_user_name" type="text" v-if="source=='EWII'" v-model="ewii_user_name">
              </div>
              <div class="mb-3">
                  <label class="form-label form-control-lg" for="ewii_password" v-if="source=='EWII'">{{ $t('Ewii password') }}</label>
                  <input class="col-xs-3 form-rounded" id="ewii_password" type="text" v-if="source=='EWII'" v-model="ewii_password">
              </div>
                <!-- Button "add new metering point". When clicked, it will call /showModal function (function to display modal pop up containing "add new metering point" form). -->
              <div class="mb-3">
                  <button type="submit" class="btn btn-primary"
                          @click.prevent="getMeteringPointsFromToken()"><i class="fas fa-bolt"></i> {{ $t('Get metering points') }}
                  </button>
              </div>

            </form>
          </div>
        </div>
        <div v-if="total==1">
          <div class="col-md-8" v-for="metering_point in metering_points" :key="metering_point.id">
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="row pv-lg">
                  <div class="col-lg-2"></div>
                  <div class="col-lg-8">
                    <form class="form-horizontal ng-pristine ng-valid">
                      <div class="form-group">
                        <label class="col-sm-6 control-label" for="inputMeteringPointId">{{ $t('Metering point id') }}</label>
                        <div class="col-sm-10">
                          <input class="form-control" id="inputMeteringPointId" type="text"
                                 v-model="form.metering_point_id">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-6 control-label" for="inputTypeOfMP">{{ $t('Type of MP') }}</label>
                        <div class="col-sm-10">
                          <input class="form-control" id="inputTypeOfMP" type="text" v-model="form.type_of_mp">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-6 control-label" for="inputSettlementMethod">{{ $t('Settlement method') }}</label>
                        <div class="col-sm-10">
                          <input class="form-control" id="inputSettlementMethod" type="text"
                                 v-model="form.settlement_method">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-6 control-label" for="inputMeterNumber">{{ $t('Meter number') }}</label>
                        <div class="col-sm-10">
                          <input class="form-control" id="inputMeterNumber" type="text" v-model="form.meter_number">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-6 control-label" for="inputConsumerCVR">{{ $t('Consumer CVR') }}</label>
                        <div class="col-sm-10">
                          <input class="form-control" id="inputConsumerCVR" type="text" v-model="form.consumer_c_v_r">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-6 control-label" for="inputDataAccessCVR">{{ $t('Data access CVR') }}</label>
                        <div class="col-sm-10">
                          <input class="form-control" id="inputDataAccessCVR" type="text"
                                 v-model="form.data_access_c_v_r">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-6 control-label" for="inputConsumerStartDate">{{ $t('Consumer start date') }}</label>
                        <div class="col-sm-10">
                          <input class="form-control" id="inputConsumerStartDate" type="text"
                                 v-model="form.consumer_start_date">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-6 control-label" for="inputMeterReadingOccurrence">{{ $t('Meter reading occurrence') }}</label>
                        <div class="col-sm-10">
                          <input class="form-control" id="inputMeterReadingOccurrence" type="text"
                                 v-model="form.meter_reading_occurrence">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-6 control-label" for="inputBalanceSupplierName">{{ $t('Balance supplier name') }}</label>
                        <div class="col-sm-10">
                          <input class="form-control" id="inputBalanceSupplierName" type="text"
                                 v-model="form.balance_supplier_name">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-6 control-label" for="inputStreetCode">{{ $t('Street code') }}</label>
                        <div class="col-sm-10">
                          <input class="form-control" id="inputStreetCode" type="text" v-model="form.street_code">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-6 control-label" for="inputStreetName">{{ $t('Street name') }}</label>
                        <div class="col-sm-10">
                          <input class="form-control" id="inputStreetName" type="text" v-model="form.street_name">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-6 control-label" for="inputBuildingNumber">{{ $t('Building number') }}</label>
                        <div class="col-sm-10">
                          <input class="form-control" id="inputBuildingNumber" type="text"
                                 v-model="form.building_number">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-6 control-label" for="inputFloorId">{{ $t('Floor id') }}</label>
                        <div class="col-sm-10">
                          <input class="form-control" id="inputFloorId" type="text" v-model="form.floor_id">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-6 control-label" for="inputRoomId">{{ $t('Room id') }}</label>
                        <div class="col-sm-10">
                          <input class="form-control" id="inputRoomId" type="text" v-model="form.room_id">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-6 control-label" for="inputCityName">{{ $t('City name') }}</label>
                        <div class="col-sm-10">
                          <input class="form-control" id="inputCityName" type="text" v-model="form.city_name">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-6 control-label" for="inputCitySubDivisionName">{{ $t('City sub division name') }}</label>
                        <div class="col-sm-10">
                          <input class="form-control" id="inputCitySubDivisionName" type="text"
                                 v-model="form.city_sub_division_name">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-6 control-label" for="inputMunicipalityCode">{{ $t('Municipality code') }}</label>
                        <div class="col-sm-10">
                          <input class="form-control" id="inputMunicipalityCode" type="text"
                                 v-model="form.municipality_code">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-6 control-label" for="inputLocationDescription">{{ $t('Location description') }}</label>
                        <div class="col-sm-10">
                          <input class="form-control" id="inputLocationDescription" type="text"
                                 v-model="form.location_description">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-6 control-label" for="inputFirstConsumerPartyName">{{ $t('First consumer party name') }}</label>
                        <div class="col-sm-10">
                          <input class="form-control" id="inputFirstConsumerPartyName" type="text"
                                 v-model="form.first_consumer_party_name">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-6 control-label" for="inputSecondConsumerPartyName">{{ $t('Second consumer party name') }}</label>
                        <div class="col-sm-10">
                          <input class="form-control" id="inputSecondConsumerPartyName" type="text"
                                 v-model="form.second_consumer_party_name">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-6 control-label" for="inputHasRelation">{{ $t('Has relation') }}</label>
                        <div class="col-sm-10">
                          <input class="form-control" id="inputHasRelation" type="text" v-model="form.hasRelation">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-6 control-label" for="inputSource">{{ $t('Source') }}</label>
                        <div class="col-sm-10">
                          <input class="form-control" id="inputSource" type="text" v-model="form.source">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="button" class="btn btn-primary"
                                  v-if="authUser && authUser!='no' && metering_point.source != 'POWERUSE'"
                                  @click="createMeteringPoint();">{{ $t('Save to poweruse') }}
                          </button>
                          <button type="button" class="btn btn-info"
                                  v-if="authUser && metering_point.source == 'POWERUSE'"
                                  @click.prevent="editMeteringPoint(metering_point);">{{ $t('Update') }}
                          </button>
                          <button type="button" class="btn btn-secondary"
                                  v-if="authUser && metering_point.source == 'POWERUSE'"
                                  @click="deleteMeteringPoint(metering_point.id)">{{ $t('Delete') }}
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-else>
          <div class="card-body table-responsive p-0">
            <!-- Data-table with pagination for metering point list. -->
            <table class="table table-hover">
              <thead>
              <tr>
                <th>{{ $t('Metering point id') }}</th>
                <th>{{ $t('Type of mp') }}</th>
                <th>{{ $t('Settlement method') }}</th>
                <th>{{ $t('Meter number') }}</th>
                <th>{{ $t('Consumer CVR') }}</th>
                <th>{{ $t('Data access CVR') }}</th>
                <th>{{ $t('Consumer start date') }}</th>
                <th>{{ $t('Meter reading occurrence') }}</th>
                <th>{{ $t('Balance supplier name') }}</th>
                <th>{{ $t('Street code') }}</th>
                <th>{{ $t('Street name') }}</th>
                <th>{{ $t('Building number') }}</th>
                <th>{{ $t('Floor id') }}</th>
                <th>{{ $t('Room id') }}</th>
                <th>{{ $t('City name') }}</th>
                <th>{{ $t('City sub division name') }}</th>
                <th>{{ $t('Municipality code') }}</th>
                <th>{{ $t('Location description') }}</th>
                <th>{{ $t('First consumer party name') }}</th>
                <th>{{ $t('Second consumer party name') }}</th>
                <th>{{ $t('Has relation') }}</th>
                <th></th>
                <th></th>
              </tr>
              </thead>
              <tbody>
              <!-- Loop through each metering point record and display metering point details -->
              <tr v-for="metering_point in metering_points" :key="metering_point.id">
                <td class="align-middle">{{ metering_point.metering_point_id }}</td>
                <td class="align-middle">{{ metering_point.type_of_mp }}</td>
                <td class="align-middle">{{ metering_point.settlement_method }}</td>
                <td class="align-middle">{{ metering_point.meter_number }}</td>
                <td class="align-middle">{{ metering_point.consumer_c_v_r }}</td>
                <td class="align-middle">{{ metering_point.data_access_c_v_r }}</td>
                <td class="align-middle">{{ metering_point.consumer_start_date }}</td>
                <td class="align-middle">{{ metering_point.meter_reading_occurrence }}</td>
                <td class="align-middle">{{ metering_point.balance_supplier_name }}</td>
                <td class="align-middle">{{ metering_point.street_code }}</td>
                <td class="align-middle">{{ metering_point.street_name }}</td>
                <td class="align-middle">{{ metering_point.building_number }}</td>
                <td class="align-middle">{{ metering_point.floor_id }}</td>
                <td class="align-middle">{{ metering_point.room_id }}</td>
                <td class="align-middle">{{ metering_point.city_name }}</td>
                <td class="align-middle">{{ metering_point.city_sub_division_name }}</td>
                <td class="align-middle">{{ metering_point.municipality_code }}</td>
                <td class="align-middle">{{ metering_point.location_description }}</td>
                <td class="align-middle">{{ metering_point.first_consumer_party_name }}</td>
                <td class="align-middle">{{ metering_point.second_consumer_party_name }}</td>
                <td class="align-middle">{{ metering_point.hasRelation }}</td>
                <td class="align-middle">
                  <a href="" @click.prevent="editMeteringPoint(metering_point)">
                    <i class="fa fa-edit"></i>
                  </a>
                  <a href="" @click.prevent="deleteMeteringPoint(metering_point.id)">
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
              </tbody>
            </table>
            <nav aria-label="Page navigation example" class="pagination-container">
              <pagination :data="metering_points" @pagination-change-page="getMeteringPoints"
                          :pageCount="last_page" :prev-text="$t('Prev')"
                          :next-text="$t('Next')"></pagination>
            </nav>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal containing dynamic form for adding/updating metering point details. -->
    <div class="modal fade" id="meteringPointModal" tabindex="-1" role="dialog"
         aria-labelledby="meteringPointModalLabel"
         aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <!-- Show/hide headings dynamically based on /isFormCreateMeteringPointMode value (true/false) -->
            <h5 v-show="isFormCreateMeteringPointMode" class="modal-title" id="meteringPointModalLabel">{{ $t('Add new metering point') }}</h5>
            <h5 v-show="!isFormCreateMeteringPointMode" class="modal-title" id="meteringPointModalLabel">{{ $t('Update metering point') }}</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <!-- Form for adding/updating metering point details. When submitted call /createMeteringPoint() function if /isFormCreateMeteringPointMode value is true. Otherwise call /updateMeteringPoint() function. -->
          <form @submit.prevent="isFormCreateMeteringPointMode ? createMeteringPoint() : updateMeteringPoint()">
            <div class="modal-body">
              <div class="form-group">
                <input v-model="form.metering_point_id" type="metering_point_id" name="metering_point_id"
                       placeholder="{{ $t('Metering point id') }}"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('metering_point_id') }">
                <has-error :form="form" field="metering_point_id"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.type_of_mp" type="type_of_mp" name="type_of_mp"
                       placeholder="{{ $t('Type of metering point') }}"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('type_of_mp') }">
                <has-error :form="form" field="type_of_mp"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.settlement_method" type="settlement_method" name="settlement_method"
                       placeholder="{{ $t('Settlement method') }}"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('settlement_method') }">
                <has-error :form="form" field="settlement_method"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.meter_number" type="meter_number" name="meter_number" placeholder="{{ $t('Meter number') }}"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('meter_number') }">
                <has-error :form="form" field="meter_number"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.consumer_c_v_r" type="consumer_c_v_r" name="consumer_c_v_r"
                       placeholder="{{ $t('Consumer CVR') }}"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('consumer_c_v_r') }">
                <has-error :form="form" field="consumer_c_v_r"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.data_access_c_v_r" type="data_access_c_v_r" name="consumer_c_v_r"
                       placeholder="{{ $t('Data access CVR') }}"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('data_access_c_v_r') }">
                <has-error :form="form" field="data_access_c_v_r"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.consumer_start_date" type="consumer_start_date" name="consumer_start_date"
                       placeholder="{{ $t('Consumer start date') }}"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('consumer_start_date') }">
                <has-error :form="form" field="consumer_start_date"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.meter_reading_occurrence" type="meter_reading_occurrence"
                       name="meter_reading_occurrence" placeholder="{{ $t('Meter reading occurrence') }}"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('meter_reading_occurrence') }">
                <has-error :form="form" field="meter_reading_occurrence"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.balance_supplier_name" type="meter_reading_occurrence" name="balance_supplier_name"
                       placeholder="{{ $t('Balance supplier name') }}"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('balance_supplier_name') }">
                <has-error :form="form" field="balance_supplier_name"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.street_code" type="text" name="street_code" placeholder="{{ $t('Street code') }}"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('street_code') }">
                <has-error :form="form" field="street_code"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.street_name" type="text" name="street_name" placeholder="{{ $t('Street name') }}"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('street_name') }">
                <has-error :form="form" field="street_name"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.building_number" type="text" name="building_number" placeholder="{{ $t('Building number') }}"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('building_number') }">
                <has-error :form="form" field="building_number"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.floor_id" type="text" name="floor_id" placeholder="{{ $t('Floor id') }}"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('floor_id') }">
                <has-error :form="form" field="floor_id"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.room_id" type="text" name="room_id" placeholder="{{ $t('Room id') }}"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('room_id') }">
                <has-error :form="form" field="room_id"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.city_name" type="text" name="city_name" placeholder="{{ $t('City name') }}"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('city_name') }">
                <has-error :form="form" field="city_name"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.city_sub_division_name" type="text" name="city_sub_division_name"
                       placeholder="{{ $t('City sub division name') }}"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('city_sub_division_name') }">
                <has-error :form="form" field="city_sub_division_name"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.municipality_code" type="text" name="municipality_code"
                       placeholder="{{ $t('Municipality code') }}"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('municipality_code') }">
                <has-error :form="form" field="municipality_code"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.location_description" type="text" name="location_description"
                       placeholder="{{ $t('Location description') }}"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('location_description') }">
                <has-error :form="form" field="location_description"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.first_consumer_party_name" type="text" name="first_consumer_party_name"
                       placeholder="{{ $t('First consumer party name') }}"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('first_consumer_party_name') }">
                <has-error :form="form" field="first_consumer_party_name"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.second_consumer_party_name" type="text" name="second_consumer_party_name"
                       placeholder="{{ $t('Second consumer party name') }}"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('second_consumer_party_name') }">
                <has-error :form="form" field="second_consumer_party_name"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.hasRelation" type="text" name="hasRelation" placeholder="{{ $t('Has Relation') }}"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('hasRelation') }">
                <has-error :form="form" field="hasRelation"></has-error>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ $t('Close') }}</button>
              <button type="submit" class="btn btn-primary" v-show="isFormCreateMeteringPointMode">{{ $t('Save changes') }}</button>
              <button type="submit" class="btn btn-primary" v-show="!isFormCreateMeteringPointMode">{{ $t('Update') }}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<!-- We put our scripts inside script tag -->
<script>
import Form from "vform";
import {trans} from 'laravel-vue-i18n';
// Declare /metering-point-management component
export default {
  props: {
    list: '',
    authUser: null
  },
  // Declare metering points (as object), form (as /vform instance) and /isFormCreateMeteringPointMode (as boolean defaulted to 'true') inside /data() { return {} }.
  data() {
    return {
      metering_points: [],
      form: new Form({
        id: '',
        metering_point_id: '',
        type_of_mp: '',
        settlement_method: '',
        meter_number: '',
        consumer_c_v_r: '',
        data_access_c_v_r: '',
        consumer_start_date: '',
        meter_reading_occurrence: '',
        balance_supplier_name: '',
        street_code: '',
        street_name: '',
        building_number: '',
        floor_id: '',
        room_id: '',
        city_name: '',
        city_sub_division_name: '',
        municipality_code: '',
        location_description: '',
        first_consumer_party_name: '',
        second_consumer_party_name: '',
        hasRelation: '',
        source: ''
      }),
      isFormCreateMeteringPointMode: true,
      last_page: 0,
      total: 0,
      token: '',
      source: 'DATAHUB',
      ewii_user_name: '',
      ewii_password: ''
    }
  },

  methods: {
    // /getMeteringPoints() function. Function we use to get metering point list by calling api/metering-points method GET.
    getMeteringPoints(page) {
      if (typeof page === 'undefined') {
        page = 1;
      }

      axios.get('api/meteringPoint', {
        params: {
          page: page
        }
      }).then(data => {
        this.metering_points = data.data.data;
        this.last_page = data.data.last_page ?? 0;
        this.total = data.data.total;
        if (this.total == 1) {
          this.form.fill(this.metering_points[0]);
        }
      });
    },
    getMeteringPointsFromToken() {
      axios.get('api/meteringPoint/' + this.token + '?source=' + this.source + '&ewii_user_name=' + this.ewii_user_name + '&ewii_password=' + this.ewii_password).then(data => {
        this.metering_points = data.data.data;
        this.last_page = data.data.last_page;
        this.total = data.data.total;
        if (this.total == 1) {
          this.form.fill(this.metering_points[0]);
        }
      });
    },
    // /showModal() function. Function we use to 1. Set /isFormCreateMeteringPointMode to 'true', 2. Reset form data, 3. Show modal containing dynamic form for adding/updating metering point details.
    showModal() {
      this.isFormCreateMeteringPointMode = true;
      this.form.reset(); // v form reset
      $('#meteringPointModal').modal('show'); // show modal
    },
    // /createMeteringPoint() function. Function we use to store metering point details by calling api/metering-points method POST (carrying form input data).
    createMeteringPoint() {
      // request post
      this.form.post('api/meteringPoint', {}).then(() => {
        $('#meteringPointModal').modal('hide'); // hide modal

        //sweet alert 2
        swal.fire({
          icon: 'success',
          title: trans('Metering Point created successfully')
        })

        this.getMeteringPoints();

      }).catch(() => {
        console.log('transaction fail');
      });
    },
    // /editMeteringPoint() function. Function we use to 1. Set /isFormCreateMeteringPointMode to 'false', 2. Reset and clear form data, 3. Show modal containing dynamic form for adding/updating metering point details, 4. Fill form with metering point details.
    editMeteringPoint(metering_point) {
      this.isFormCreateMeteringPointMode = false;
      this.form.reset(); // v form reset inputs
      this.form.clear(); // v form clear errors
      $('#meteringPointModal').modal('show'); // show modal
      this.form.fill(metering_point);
    },
    // /updateMeteringPoint() function. Function we use to update metering point details by calling api/metering-points/{id} method PUT (carrying form input data).
    updateMeteringPoint() {
      // request put
      this.form.put('api/meteringPoint/' + this.form.id, {}).then(() => {
        $('#meteringPointModal').modal('hide'); // hide modal

        //sweet alert 2
        swal.fire({
          icon: 'success',
          title: trans('Metering point updated successfully')
        })

        this.getMeteringPoints();
      }).catch(() => {
        console.log('transaction fail');
      });
    },
    // /deleteMeteringPoint() function. Function we use to delete metering point record by calling api/metering-points/{id} method DELETE.
    deleteMeteringPoint(id) {
      // sweet alert confirmation
      swal.fire({
        title: trans('Are you sure?'),
        text: trans("You won't be able to revert this!"),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: trans('Yes, delete it!')
      }).then((result) => {
        // confirm delete?
        if (result.value) {
          // request delete
          this.form.delete('api/meteringPoint/' + id, {}).then(() => {
            // sweet alert success
            swal.fire(
                trans('Deleted!'),
                trans('Metering point has been deleted.'),
                'success'
            )

            this.getMeteringPoints(); // reload table metering_points
          }).catch(() => {
            // sweet alert fail
            swal.fire({
              icon: 'error',
              title: trans('Oops...'),
              text: trans('Something went wrong!'),
              footer: '<a href>' + trans('Why do I have this issue?') + '</a>'
            })
          });
        }
      })
    }
  },
  created() {
    this.getMeteringPoints();
  }
}
</script>
