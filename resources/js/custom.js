//https://blog.madbob.org/fixing-vite-bootstrap-jquery/
import $ from 'jquery';
import {Modal, Tooltip, Popover} from "bootstrap";

function defineJQueryPlugin(plugin) {
    const name = plugin.NAME;
    const JQUERY_NO_CONFLICT = $.fn[name];
    $.fn[name] = plugin.jQueryInterface;
    $.fn[name].Constructor = plugin;
    $.fn[name].noConflict = () => {
        $.fn[name] = JQUERY_NO_CONFLICT;
        return plugin.jQueryInterface;
    }
}

defineJQueryPlugin(Modal);
defineJQueryPlugin(Tooltip);
defineJQueryPlugin(Popover);
