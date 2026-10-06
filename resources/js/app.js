import './bootstrap'

import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse'
import siteHeader from './components/siteHeader'
import quoteForm from './components/quoteForm'
import reveal from './components/reveal'

Alpine.plugin(collapse)
Alpine.data('siteHeader', siteHeader)
Alpine.data('quoteForm', quoteForm)
Alpine.directive('reveal', reveal)

window.Alpine = Alpine
Alpine.start()
