// x-reveal: animates an element in the first time it enters the viewport.
//   x-reveal              fade up (default)
//   x-reveal.left|right|down|zoom   other entrances
//   x-reveal.200          delay in ms (combine: x-reveal.right.200)
// Respects prefers-reduced-motion. Once finished, the helper classes are removed
// so hover/transition utilities on the element behave normally again.
const VARIANTS = ['up', 'down', 'left', 'right', 'zoom']

export default (el, { modifiers }, { cleanup }) => {
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return

  const variant = modifiers.find((m) => VARIANTS.includes(m)) ?? 'up'
  const delay = parseInt(modifiers.find((m) => /^\d+$/.test(m)) ?? 0, 10)
  const classes = ['reveal', `reveal-${variant}`]

  el.classList.add(...classes)
  el.style.transitionDelay = `${delay}ms`

  const done = () => {
    el.classList.remove(...classes, 'is-visible')
    el.style.transitionDelay = ''
  }

  const observer = new IntersectionObserver(
    ([entry]) => {
      if (!entry.isIntersecting) return
      observer.disconnect()
      // next frame so the hidden state is painted before transitioning
      requestAnimationFrame(() => el.classList.add('is-visible'))
      setTimeout(done, 900 + delay)
    },
    { threshold: 0.12, rootMargin: '0px 0px -5% 0px' },
  )

  observer.observe(el)
  cleanup(() => observer.disconnect())
}
