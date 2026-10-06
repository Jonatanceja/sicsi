// x-countup: counts a number up (keeping prefix/suffix such as "+", "%", "°") when it scrolls into view.
// Years (1900–2100) and zero are left untouched.
export default (el, _, { cleanup }) => {
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return

  const text = el.textContent.trim()
  const match = text.match(/^([^\d]*)(\d[\d.,]*)(.*)$/)
  if (!match) return

  const [, prefix, number, suffix] = match
  const target = parseFloat(number.replace(/,/g, ''))
  const isYear = !number.includes(',') && !number.includes('.') && target >= 1900 && target <= 2100
  if (!target || isYear) return

  const decimals = number.includes('.') ? number.split('.')[1].length : 0
  const format = (value) =>
    value.toLocaleString('en-US', {
      minimumFractionDigits: decimals,
      maximumFractionDigits: decimals,
      useGrouping: number.includes(','),
    })

  el.setAttribute('aria-label', text)
  el.textContent = `${prefix}${format(0)}${suffix}`

  const observer = new IntersectionObserver(
    ([entry]) => {
      if (!entry.isIntersecting) return
      observer.disconnect()

      const duration = 1400
      const start = performance.now()
      const tick = (now) => {
        const progress = Math.min((now - start) / duration, 1)
        const eased = 1 - Math.pow(1 - progress, 3)
        el.textContent = `${prefix}${format(target * eased)}${suffix}`
        if (progress < 1) requestAnimationFrame(tick)
        else el.textContent = text
      }
      requestAnimationFrame(tick)
    },
    { threshold: 0.6 },
  )

  observer.observe(el)
  cleanup(() => observer.disconnect())
}
