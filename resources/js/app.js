import './bootstrap'

import Alpine from 'alpinejs'
import siteHeader from './components/siteHeader'
import quoteForm from './components/quoteForm'
import reveal from './components/reveal'

Alpine.data('siteHeader', siteHeader)
Alpine.data('quoteForm', quoteForm)
Alpine.directive('reveal', reveal)

window.Alpine = Alpine
Alpine.start()
