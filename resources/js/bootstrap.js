import _ from 'lodash';
window._ = _;

import $ from 'jquery';
window.$ = $;

import * as Popper from '@popperjs/core';
window.Popper = Popper;

import 'bootstrap';

import './custom';


/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';



