<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"> {{ $t('Charges') }} - {{ metering_point_gsrn }}</h3>
          <div class="card-tools" v-if="authUser && authUser!='no'">
            <div class="input-group input-group-sm">
              <!-- Button "add new metering point". When clicked, it will call /showModal function (function to display modal pop up containing "add new metering point" form). -->
              <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#chargeModal"
                      @click.prevent="showModal"><i class="fas fa-bolt"></i> {{ $t('Add new charge') }}
              </button>
            </div>
          </div>
          <hr />
          <div class="card-tools">
            <div class="input-group-sm">
              <form class="form">
                <div class="mb-3" v-if="!authUser.refresh_token">
                  <label class="col-sm-3 control-label" for="token">{{ $t('Refresh token') }}</label>
                  <input class="col-lg-4 form-rounded" id="token" type="text" v-model="token">
                </div>
                <div class="mb-3">
                  <!-- Button "add new metering point". When clicked, it will call /showModal function (function to display modal pop up containing "add new metering point" form). -->
                  <button type="submit" class="btn btn-primary"
                          @click.prevent="getChargesFromToken()"><i class="fas fa-bolt"></i>{{ $t('Get charges') }}
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div>
          <div class="card-body table-responsive p-0">
            <!-- Data-table with pagination for metering point list. -->
            <table class="table table-hover">
              <thead>
              <tr>
                <th>{{ $t('Type') }}</th>
                <th>{{ $t('Name') }}</th>
                <th>{{ $t('Description') }}</th>
                <th>{{ $t('Owner') }}</th>
                <th>{{ $t('Valid from') }}</th>
                <th>{{ $t('Valid to') }}</th>
                <th>{{ $t('Period type') }}</th>
                <th>{{ $t('Price') }}</th>
                <th>{{ $t('Quantity') }}</th>
                <th>{{ $t('Prices') }}</th>
                <th></th>
                <th></th>
              </tr>
              </thead>
              <tbody>

              <tr v-for="charge in charges" :key="charge.id">
                <td class="align-middle">{{ charge.type }}</td>
                <td class="align-middle">{{ charge.name }}</td>
                <td class="align-middle">{{ charge.description }}</td>
                <td class="align-middle">{{ charge.owner }}</td>
                <td class="align-middle">{{ charge.validFromDate }}</td>
                <td class="align-middle">{{ charge.validToDate }}</td>
                <td class="align-middle">{{ charge.periodType }}</td>
                <td class="align-middle">{{ charge.price }}</td>
                <td class="align-middle">{{ charge.quantity }}</td>
                <td class="align-middle">
                  <div v-if="charge.prices && charge.prices.length!=0">
                    <table class="table table-hover">
                      <thead>
                      <tr>
                        <th>{{ $t('Position') }}</th>
                        <th>{{ $t('Price') }}</th>
                      </tr>
                      </thead>
                      <tbody>
                      <tr v-for="chargePrice in charge.prices" :key="chargePrice.id">
                        <td class="align-middle">{{ chargePrice.position }}</td>
                        <td class="align-middle">{{ chargePrice.price }}</td>
                      </tr>
                      </tbody>
                    </table>
                  </div>
                </td>
                <td class="align-middle">
                  <a href="" v-if="authUser && (charges[0] ? charges[0].source : '') == 'POWERUSE'"
                     @click.prevent="editCharge(charge)">
                    <i class="fa fa-edit"></i>
                  </a>
                  <a href="" v-if="authUser && (charges[0] ? charges[0].source : '') == 'POWERUSE'"
                     @click.prevent="deleteCharge(charge.id)">
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
              </tbody>
            </table>
            <nav aria-label="Page navigation example" class="pagination-container">
              <pagination :data="charges" @pagination-change-page="getCharges"
                          :pageCount="last_page" :prev-text="$t('Prev')"
                          :next-text="$t('Next')"></pagination>
            </nav>
            <button type="button" class="btn btn-primary m-2"
                    v-if="authUser && authUser!='no' && ((charges && charges[0]) ? charges[0].source : '') != 'POWERUSE'"
                    @click.prevent="saveCharges()">{{ $t('Save all charges to DB') }}
            </button>
            <button type="button" class="btn btn-danger m-2"
                    v-if="authUser && ((charges && charges[0]) ? charges[0].source : '') == 'POWERUSE'"
                    @click.prevent="deleteCharges(metering_point_id)">{{ $t('Delete all charges in DB') }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal containing dynamic form for adding/updating metering point details. -->
    <div class="modal fade" id="chargeModal" tabindex="-1" role="dialog" aria-labelledby="chargeModalLabel"
         aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <!-- Show/hide headings dynamically based on /isFormCreateMeteringPointMode value (true/false) -->
            <h5 v-show="isFormCreateChargeMode" class="modal-title" id="chargeModalLabel">{{ $t('Add new charge') }}</h5>
            <h5 v-show="!isFormCreateChargeMode" class="modal-title" id="chargeModalLabel"> {{ $t('Update charge') }}</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <!-- Form for adding/updating metering point details. When submitted call /createMeteringPoint() function if /isFormCreateMeteringPointMode value is true. Otherwise call /updateMeteringPoint() function. -->
          <form @submit.prevent="isFormCreateChargeMode ? createCharge() : updateCharge()">
            <div class="modal-body">
              <div class="form-group">
                <input v-model="form.type" type="text" name="type"
                       :placeholder="$t('Type of charge')"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                <has-error :form="form" field="type"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.name" type="text" name="name"
                       :placeholder="$t('Name')"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                <has-error :form="form" field="name"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.description" type="text" name="description" :placeholder="$t('Description')"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                <has-error :form="form" field="description"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.owner" type="text" name="owner"
                       :placeholder="$t('Owner')"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('owner') }">
                <has-error :form="form" field="owner"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.valid_from" type="text" name="valid_from"
                       :placeholder="$t('Valid from')"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('valid_from') }">
                <has-error :form="form" field="valid_from"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.valid_to" type="text" name="valid_to"
                       :placeholder="$t('Valid to')"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('valid_to') }">
                <has-error :form="form" field="valid_to"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.period_type" type="text"
                       name="period_type" :placeholder="$t('Period type')"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('period_type') }">
                <has-error :form="form" field="period_type"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.price" type="text" name="price"
                       :placeholder="$t('Price')"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('price') }">
                <has-error :form="form" field="price"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.quantity" type="text" name="quantity" :placeholder="$t('Quantity')"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('quantity') }">
                <has-error :form="form" field="quantity"></has-error>
              </div>
              <div class="form-group">
                <button
                    type="button"
                    class="btn btn-primary"
                    @click="addMore()">
                  {{ $t('Add price') }}
                </button>
                <div v-for="(price, index) in form.prices" :key="index">
                  <div class="row-cols-2">
                    <div class="row">
                      <div class="form-group col-xs-4 col-md-4">
                        <label for="position" class="control-label">{{ $t('Position') }}</label>
                        <input
                            v-model="price.position" id="position"
                            placeholder="Position"
                            class="form-control"/>
                      </div>
                      <div class="form-group col-xs-4 col-md-4">
                        <label for="price" class="control-label">{{ $t('Price') }}</label>
                        <input
                            v-model="price.price" id="price"
                            placeholder="Price"
                            class="form-control"/>
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-xs-4 col-md-4">
                    <button
                        type="button"
                        class="btn btn-primary"
                        @click="remove(index)">
                      {{ $t('Remove') }}
                    </button>
                  </div>
                </div>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ $t('Close') }}</button>
              <button type="submit" class="btn btn-primary" v-show="isFormCreateChargeMode">{{ $t('Save changes') }}</button>
              <button type="submit" class="btn btn-primary" v-show="!isFormCreateChargeMode">{{ $t('Update') }}</button>
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
    'auth-user': ''
  },
  // Declare metering points (as object), form (as /vform instance) and /isFormCreateMeteringPointMode (as boolean defaulted to 'true') inside /data() { return {} }.
  data() {
    return {
      charges: [{
        id: '',
        prices: [{
          position: 1,
          price: ''
        }]
      }],
      form: new Form({
        id: '',
        type: '',
        name: '',
        description: '',
        owner: '',
        valid_from: '',
        valid_to: '',
        period_type: '',
        price: '',
        quantity: '',
        prices: [{position: 1, price: ''}],
      }),
      isFormCreateChargeMode: true,
      last_page: 0,
      total: 0,
      token: '',
      metering_point_id: '',
      metering_point_gsrn: ''
    }
  },

  methods: {
    addMore() {
      this.form.prices.push({
        position: this.form.prices.slice(-1)[0] ? this.form.prices.slice(-1)[0].position + 1 : 1,
        price: ''
      });
    },
    remove(index) {
      this.form.prices.splice(index, 1);
    },
    // /getMeteringPoints() function. Function we use to get metering point list by calling api/metering-points method GET.
    getCharges(page) {
      if (typeof page === 'undefined') {
        page = 1;
      }

      axios.get('api/charge', {
        params: {
          page: page
        }
      }).then(data => {
        let arr = [];
        if (data.data.data) {
          data.data.data.forEach((value, index) => {
            value.forEach((value2, index2) => {
              let type = '';
              switch (index) {
                case 0:
                  type = "Abonnement";
                  break;
                case 1:
                  type = "Tarif";
                  break;
                case 2:
                  type = "Gebyr";
                  break;
                default:
                  type = "";
              }
              if (type != "") {
                value2.type = type;
                value2.periodType = value2.periodType ?? value2.period_type;
                value2.validFromDate = value2.validFromDate ?? value2.valid_from;
                value2.validToDate = value2.validFToDate ?? value2.valid_to;
                arr.push(value2);
              }
            });
          });
          this.charges = arr;
          this.last_page = data.data.last_page;
          this.total = data.data.total;
          this.metering_point_id = data.data.data[3][0]['metering_point_id'];
          this.metering_point_gsrn = data.data.data[4][0]['metering_point_gsrn'];
          if (this.total == 1) {
            this.form.fill(this.charges[0]);
          }
        }
      });
    },
    getChargesFromToken() {
      axios.get('api/charge/' + this.token).then(data => {
        let arr = [];
        if (data.data.data) {
          data.data.data.forEach((value, index) => {
            value.forEach((value2, index2) => {
              let type = '';
              switch (index) {
                case 0:
                  type = "Abonnement";
                  break;
                case 1:
                  type = "Tarif";
                  break;
                case 2:
                  type = "Gebyr";
                  break;
                default:
                  type = "";
              }
              if (type != "") {
                value2.type = type;
                arr.push(value2);
              }
            });
          });
          this.charges = arr;
          this.last_page = data.data.last_page;
          this.total = data.data.total;
          this.metering_point_id = data.data.data[3][0]['metering_point_id'];
          this.metering_point_gsrn = data.data.data[4][0]['metering_point_gsrn'];
          if (this.total == 1) {
            this.form.fill(this.charges[0]);
          }
        }
      });
    },
    // /showModal() function. Function we use to 1. Set /isFormCreateMeteringPointMode to 'true', 2. Reset form data, 3. Show modal containing dynamic form for adding/updating metering point details.
    showModal() {
      this.isFormCreateChargeMode = true;
      this.form.reset(); // v form reset
      $('#chargeModal').modal('show'); // show modal
    },
    // /createMeteringPoint() function. Function we use to store metering point details by calling api/metering-points method POST (carrying form input data).
    createCharge() {
      // request post
      this.form.post('api/charge', {}).then(() => {
        $('#chargeModal').modal('hide'); // hide modal

        //sweet alert 2
        swal.fire({
          icon: 'success',
          title: trans('Charge saved successfully')
        })

        this.getCharges();

      }).catch(() => {
        console.log('transaction fail');
      });
    },
    // /editCharge() function. Function we use to 1. Set /isFormCreateMeteringPointMode to 'false', 2. Reset and clear form data, 3. Show modal containing dynamic form for adding/updating metering point details, 4. Fill form with metering point details.
    saveCharge(charge, sweetAlert = true) {
      // request post
      let formData = new FormData();


      let keys = Object.keys(charge);
      let values = Object.values(charge);
      let myo2 = {};
      let arr = [];
      for (let i = 0; i < Object.keys(charge).length; i++) {
        arr = [];
        let key = keys[i];

        switch (keys[i]) {
          case 'validFromDate':
            key = 'valid_from';
            break;
          case 'validToDate':
            key = 'valid_to';
            break;
          case 'periodType':
            key = 'period_type';
            break;
          case 'prices':
            let prices = values[i];
            for (let j = 0; j < Object.keys(prices).length; j++) {
              myo2 = {};
              let price_key = Object.keys(prices[j]);
              let price_value = Object.values(prices[j]);

              for (let k = 0; k < Object.keys(price_key).length; k++) {
                myo2 = Object.defineProperty(myo2, price_key[k], {value: price_value[k]});
              }
              arr.push(myo2);
            }
            break;
          default:
            key = keys[i];
        }
        if (arr.length != 0) {
          let n = 0;
          arr.forEach(function (item) {
            for (let m = 0; m < Object.getOwnPropertyNames(item).length; m++) {
              switch (m) {
                case 0:
                  formData.append("prices." + n + ".position", item.position);
                  break;
                case 1:
                  formData.append("prices." + n + ".price", item.price);
                  break;
                default:
              }
            }
            n = n + 1;
          });

        } else {
          if (values[i] == null) {
            values[i] = '';
          }
          formData.append(key, values[i]);
        }
      }
      formData.append('metering_point_id', this.metering_point_id);

      axios.defaults.headers.post['Content-Type'] = 'application/json';

      axios.post('api/charge', formData).then(() => {
        if (sweetAlert) {
          //sweet alert 2
          swal.fire({
            icon: 'success',
            title: trans('Charge saved successfully')
          })
        }

        this.getCharges();

      }).catch(() => {
        console.log('transaction fail');
      });
    },
    saveCharges() {
      let _this = this;
      this.charges.forEach(function (charge) {
        _this.saveCharge(charge, false);
      });
      swal.fire({
        icon: 'success',
        title: trans('All charges saved successfully')
      })
    },
    // /editCharge() function. Function we use to 1. Set /isFormCreateMeteringPointMode to 'false', 2. Reset and clear form data, 3. Show modal containing dynamic form for adding/updating metering point details, 4. Fill form with metering point details.
    editCharge(charge) {
      this.isFormCreateChargeMode = false;
      this.form.reset(); // v form reset inputs
      this.form.clear(); // v form clear errors
      $('#chargeModal').modal('show'); // show modal
      this.form.fill(charge);
    },
    // /updateMeteringPoint() function. Function we use to update metering point details by calling api/metering-points/{id} method PUT (carrying form input data).
    updateCharge() {
      // request put
      this.form.put('api/charge/' + this.form.id, {}).then(() => {
        $('#chargeModal').modal('hide'); // hide modal

        //sweet alert 2
        swal.fire({
          icon: 'success',
          title: trans('Charge updated successfully')
        })

        this.getCharges();
      }).catch(() => {
        console.log('transaction fail');
      });
    },
    // /deleteMeteringPoint() function. Function we use to delete metering point record by calling api/metering-points/{id} method DELETE.
    deleteCharges(metering_point_id) {
      // sweet alert confirmation
      swal.fire({
        title: trans('Are you sure?'),
        text: trans("You won't be able to revert this!"),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: trans('Yes, delete them!'),
        cancelButtonText: trans('Cancel')
      }).then((result) => {
        // confirm delete?
        if (result.value) {
          // request delete
          axios.delete('api/charges/' + metering_point_id, {}).then(() => {
            // sweet alert success
            swal.fire(
                trans('Deleted!'),
                trans('Charges have been deleted.'),
                'success'
            )

            this.charges = null;
            this.getCharges();
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
      });
    },
    // /deleteCharge() function. Function we use to delete metering point record by calling api/metering-points/{id} method DELETE.
    deleteCharge(id) {
      // sweet alert confirmation
      swal.fire({
        title: trans('Are you sure?'),
        text: trans("You won't be able to revert this!"),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: trans('Yes, delete it!'),
        cancelButtonText: trans('Cancel')
      }).then((result) => {
        // confirm delete?
        if (result.value) {
          // request delete
          axios.delete('api/charge/' + id, {}).then(() => {
            // sweet alert success
            swal.fire(
                trans('Deleted!'),
                trans('Charges have been deleted.'),
                'success'
            )

            this.charges = null;
            this.getCharges();
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
      });
    }

  },
  created() {
    this.getCharges();
  }
}
</script>
