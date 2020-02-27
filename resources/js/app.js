require('./bootstrap');

window.Vue = require('vue');
import AttributeSelect from './components/attribute-select.vue';
import ProductAttributes from './components/product-attributes.vue';
import SearchProducts from './components/search-products.vue';

Vue.component(
    'attribute-select',
    AttributeSelect
);
Vue.component(
    'product-attributes',
    ProductAttributes
);
Vue.component(
    'search-products',
    SearchProducts
);
new Vue({
    el: '#content'
});