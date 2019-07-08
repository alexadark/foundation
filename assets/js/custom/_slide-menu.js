import { $, $$ } from './_utilities';

const trigger = $('.header-menu__trigger');
const slideMenu = $('.slide-menu');
const close = $('.slide-menu__close');
const itemsWithChildrens = $$('.slide-menu .menu-item-has-children');
var $diff = 0;
// const openChildrensTrigger;
// console.log(dataset('after'));
itemsWithChildrens.forEach(item =>
	item.on('click', e => {
		$diff = jQuery(item).width() - e.offsetX;
		if ($diff <= 40) {
			item.classList.toggle('active');
		} else {
			//console.log('clicked not after' + (jQuery(item).width() +' - '+ e.offsetX) +' = ' + $diff);
		}
	})
);

const openMenu = () => slideMenu.classList.add('isOpen');
const closeMenu = () => slideMenu.classList.remove('isOpen');

trigger.on('click', openMenu);
close.on('click', closeMenu);

// itemWithChildrens.on('click', () => this.classList.add('itemOpen'));

//Hamburger
// $('.hamburger').on('click', function() {
// 	this.classList.toggle('open');
// });
