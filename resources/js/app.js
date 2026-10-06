import './bootstrap'

import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse'
import siteHeader from './components/siteHeader'
import quoteForm from './components/quoteForm'
import reveal from './components/reveal'
import countup from './components/countup'

Alpine.plugin(collapse)
Alpine.data('siteHeader', siteHeader)
Alpine.data('quoteForm', quoteForm)
Alpine.directive('reveal', reveal)
Alpine.directive('countup', countup)

window.Alpine = Alpine
Alpine.start()
