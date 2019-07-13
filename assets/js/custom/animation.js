import { $, $$ } from './_utilities';
const w = window.innerWidth;

// heroanimation

const heroTitle = $('.home .hero__title');
const heroRedButton = $('.home .hero__buttons .button--salmon');
const heroBlueButton = $('.home .hero__buttons .button--blue');
const homeHeader = $('.home .header__content');

try {
	const animHeroTl = new TimelineMax();

	animHeroTl
		.to(homeHeader, 2, { opacity: 1 })
		.fromTo(heroTitle, 2, { y: 10 }, { opacity: 1, y: 0 }, '-=1.5');

	heroRedButton.classList.add('fadeInUp');
	heroBlueButton.classList.add('fadeInUpLong');
	setTimeout(function() {
		heroRedButton.classList.remove('hidden');
		heroBlueButton.classList.remove('hidden');
	}, 3000);
} catch (error) {
	console.log(error);
}

// AnimatedText
const texts = $$('.animated-text__item');

const animTextTl = new TimelineMax({
	repeat: -1,
	repeatDelay: 0.3,
	paused: false,
});

texts.forEach(textItem => {
	animTextTl.to(textItem, 1, { opacity: 1 }).to(textItem, 1, { opacity: 0 });
});

//Scroll animation

//Top Menu

var controller = new ScrollMagic.Controller();
if (w > 768) {
	const menuScene = new ScrollMagic.Scene({
		triggerElement: '.header',
		triggerHook: 0,
		offset: 400,
	})
		.setClassToggle('#fixedMenu', 'active')
		// .addIndicators()
		.addTo(controller);
}

//Glasses

const glassesTween = new TweenMax.to('#glasses', 4, {
	scale: 1.2,
	y: -10,
	x: -50,
	rotation: 8,
	transformOrigin: 'center center',
});

const glassesScene = new ScrollMagic.Scene({
	triggerElement: '.home .hero__title',
	triggerHook: 0,
})
	.setTween(glassesTween)
	// .addIndicators()
	.addTo(controller);

//Triangle

const triangleTween = new TweenMax.fromTo(
	'#triangle',
	4,
	{ x: 165, y: -49, rotation: -10, transformOrigin: 'center center' },
	{
		y: 50,
		x: -50,
		rotation: 50,
		transformOrigin: 'center center',
	}
);

const triangleScene = new ScrollMagic.Scene({
	triggerElement: '.home .hero__buttons',
	triggerHook: 0,
})
	.setTween(triangleTween)
	.addTo(controller);

//Two col

const twoColTween = new TimelineMax()
	.fromTo(
		'.home-2cols__item:first',
		2,
		{ y: 100, opacity: 0 },
		{ y: 0, opacity: 1 }
	)
	.fromTo(
		'.home-2cols__item:last',
		2,
		{ y: 150, opacity: 0 },
		{ y: 0, opacity: 1 },
		'-=1.5'
	);

const twoColScene = new ScrollMagic.Scene({
	triggerElement: '.home-2cols',
	triggerHook: 1,
	offset: 100,
})
	.setTween(twoColTween)
	// .addIndicators()
	.addTo(controller);

//Asteroid

const asteroidTween = new TimelineMax()
	.fromTo(
		'.asteroid',
		2,
		{
			x: -120,
			y: 120,
			scale: 0.9,
		},
		{
			x: 0,
			y: 0,
			scale: 1,
		}
	)
	.fromTo(
		'.home-asteroid__text',
		2,
		{
			opacity: 0,
			y: 150,
		},
		{
			opacity: 1,
			y: 0,
		},
		'-=1.5'
	);
if (w >= 1200 && w <= 1442) {
	const asteroidScene = new ScrollMagic.Scene({
		triggerElement: '.asteroid',
		triggerHook: 1,
		offset: 200,
	})
		.setTween(asteroidTween)
		// .addIndicators()
		.addTo(controller);
}
//Blue zone

const blueTween = new TweenMax.fromTo(
	'.home-blue-section__content',
	2,
	{ y: 200, opacity: 0 },
	{ y: 100, opacity: 1 }
);

const blueScene = new ScrollMagic.Scene({
	triggerElement: '.home-blue-section__content',
	triggerHook: 1,
	offset: 100,
})
	.setTween(blueTween)
	// .addIndicators()
	.addTo(controller);

//Services

const servicesTween = new TimelineMax().fromTo(
	'.home .featured-services__container',
	2,
	{ y: 50 },
	{ y: 0 }
);

const servicesScene = new ScrollMagic.Scene({
	triggerElement: '.home .featured-services__container',
	triggerHook: 1,
	offset: 120,
})
	.setTween(servicesTween)
	// .addIndicators()
	.addTo(controller);

//Macbook

// const macBook = CSSRulePlugin.getRule('.home .resources:before');
// const macBookTween = new TweenMax.fromTo(
// 	macBook,
// 	2,
// 	{ cssRule: { y: 100 } },
// 	{ cssRule: { y: 0 } }
// );
// const macBookScene = new ScrollMagic.Scene({
// 	triggerElement: '.home .resources',
// 	triggerHook: 1,
// 	offset: 200,
// })
// 	.setTween(macBookTween)
// 	.addIndicators()
// 	.addTo(controller);
