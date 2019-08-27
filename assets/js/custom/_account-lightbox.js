import { $ } from './_utilities'

const cancel = $('.cancel-link')
const cancelLb = $('.cancel-lb')
const upgrade = $('.upgrade-link')
const upgradeLb = $('.upgrade-lb')
const closeCancel = $('.cancel-lb .close')
const closeUpgrade = $('.upgrade-lb .close')
const lbCancel = $('.cancel-lb')
const lbUpgrade = $('.upgrade-lb')
const closeLbCancel = () => lbCancel.classList.remove('active')
const closeLbUpgrade = () => lbUpgrade.classList.remove('active')
const buttonGreenCancel = $('.cancel-lb .button--green')
const buttonGreenUpgrade = $('.upgrade-lb .button--green')

cancel.on('click', e => {
	e.preventDefault()
	cancelLb.classList.add('active')
})

upgrade.on('click', e => {
	e.preventDefault()
	upgradeLb.classList.add('active')
})

closeCancel.on('click', closeLbCancel)
closeUpgrade.on('click', closeLbUpgrade)
buttonGreenCancel.on('click', closeLbCancel)
buttonGreenUpgrade.on('click', closeLbUpgrade)
