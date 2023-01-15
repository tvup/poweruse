<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Charges - {{ metering_point_gsrn }}</h3>
          <div class="card-tools" v-if="authUser && authUser.refresh_token">
            <div class="input-group input-group-sm">
              <!-- Button "add new metering point". When clicked, it will call /showModal function (function to display modal pop up containing "add new metering point" form). -->
              <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#chargeModal"
                      @click.prevent="showModal"><i class="fas fa-bolt"></i> Add new charge
              </button>
            </div>
          </div>
          <div class="card-tools" v-else>
            <div class="input-group input-group-sm">
              <form>
                <label class="col-sm-3 control-label" for="token">Refresh token</label>
                <input class="form-control" id="token" type="text" v-model="token">
                <!-- Button "add new metering point". When clicked, it will call /showModal function (function to display modal pop up containing "add new metering point" form). -->
                <button type="submit" class="btn btn-primary"
                        @click.prevent="getChargesFromToken()"><i class="fas fa-bolt"></i> Get charges
                </button>
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
                <th>Type</th>
                <th>Name</th>
                <th>Description</th>
                <th>Owner</th>
                <th>Valid from</th>
                <th>Valid to</th>
                <th>Period type</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Prices</th>
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
                  <div v-if="charge.prices">
                    <table class="table table-hover">
                      <thead>
                      <tr>
                        <th>Position</th>
                        <th>Price</th>
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
                  <a href="" v-if="authUser && (charges[0] ? charges[0].source : '') == 'Poweruse'" @click.prevent="editCharge(charge)">
                    <i class="fa fa-edit"></i>
                  </a>
                  <a href="" v-if="authUser && (charges[0] ? charges[0].source : '') == 'Poweruse'" @click.prevent="deleteCharge(charge.id)">
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
              </tbody>
            </table>
            <nav aria-label="Page navigation example" class="pagination-container">
              <pagination :data="charges" @pagination-change-page="getCharges"
                          :pageCount="last_page"></pagination>
            </nav>
            <button type="button" class="btn btn-primary" v-if="authUser && (charges[0] ? charges[0].source : '') != 'Poweruse'" @click.prevent="saveCharges()">Save all charges to DB</button>
            <button type="button" class="btn btn-danger" v-if="authUser && (charges[0] ? charges[0].source : '') == 'Poweruse'" @click.prevent="deleteCharges(metering_point_id)">Delete all charges in DB</button>
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
            <h5 v-show="isFormCreateChargeMode" class="modal-title" id="chargeModalLabel">Add new charge</h5>
            <h5 v-show="!isFormCreateChargeMode" class="modal-title" id="chargeModalLabel">Update charge</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <!-- Form for adding/updating metering point details. When submitted call /createMeteringPoint() function if /isFormCreateMeteringPointMode value is true. Otherwise call /updateMeteringPoint() function. -->
          <form @submit.prevent="isFormCreateChargeMode ? createCharge() : updateCharge()">
            <div class="modal-body">
              <div class="form-group">
                <input v-model="form.charge_id" type="metering_point_id" name="metering_point_id"
                       placeholder="Charge id"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('charge_id') }">
                <has-error :form="form" field="metering_point_id"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.type" type="type" name="type_of_mp"
                       placeholder="Type of charge"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                <has-error :form="form" field="type"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.name" type="name" name="name"
                       placeholder="Name"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                <has-error :form="form" field="name"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.description" type="description" name="description" placeholder="Description"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                <has-error :form="form" field="description"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.owner" type="owner" name="owner"
                       placeholder="Owner"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('owner') }">
                <has-error :form="form" field="owner"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.valid_from" type="valid_from" name="valid_from"
                       placeholder="Valid from"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('valid_from') }">
                <has-error :form="form" field="valid_from"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.valid_to" type="valid_to" name="valid_to"
                       placeholder="Valid to"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('valid_to') }">
                <has-error :form="form" field="valid_to"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.period_type" type="period_type"
                       name="period_type" placeholder="Period type"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('period_type') }">
                <has-error :form="form" field="period_type"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.price" type="price" name="price"
                       placeholder="Price"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('price') }">
                <has-error :form="form" field="price"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.quantity" type="text" name="quantity" placeholder="Quantity"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('quantity') }">
                <has-error :form="form" field="quantity"></has-error>
              </div>
              <div class="form-group">
                <input v-model="form.prices" type="text" name="prices" placeholder="Prices"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('prices') }">
                <has-error :form="form" field="prices"></has-error>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" v-show="isFormCreateChargeMode">Save changes</button>
              <button type="submit" class="btn btn-primary" v-show="!isFormCreateChargeMode">Update</button>
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
// Declare /metering-point-management component
export default {
  props: {
    list: '',
    'auth-user': ''
  },
  // Declare metering points (as object), form (as /vform instance) and /isFormCreateMeteringPointMode (as boolean defaulted to 'true') inside /data() { return {} }.
  data() {
    return {
      charges: [],
      form: new Form({
        id: '',
        type: '',
        description: '',
        owner: '',
        valid_from: '',
        valid_to: '',
        period_type: '',
        price: '',
        quantity: '',
        prices: '',
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
          title: 'Charge saved successfully'
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
            title: 'Charge saved successfully'
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
        title: 'All charges saved successfully'
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
          title: 'Charge updated successfully'
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
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        // confirm delete?
        if (result.value) {
          // request delete
          axios.delete('api/charge/' + metering_point_id, {}).then(() => {
            // sweet alert success
            swal.fire(
                'Deleted!',
                'Charges have been deleted.',
                'success'
            )

            this.charges = null;
            this.getCharges();
          }).catch(() => {
            // sweet alert fail
            swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!',
              footer: '<a href>Why do I have this issue?</a>'
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
