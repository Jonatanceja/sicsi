// x-reveal: fades an element up the first time it enters the viewport.
export default (el, { value, modifiers }, { cleanup }) => {
  const delay = parseInt(value || modifiers[0] || 0, 10)

  el.classList.add('opacity-0', 'translate-y-5', 'transition', 'duration-700', 'ease-out')
  el.style.transitionDelay = `${delay}ms`

  const observer = new IntersectionObserver(
    ([entry]) => {
      if (!entry.isIntersecting) return
      el.classList.remove('opacity-0', 'translate-y-5')
      observer.disconnect()
    },
    { threshold: 0.12 },
  )

  observer.observe(el)
  cleanup(() => observer.disconnect())
}
