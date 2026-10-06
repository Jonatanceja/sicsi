export default () => ({
  open: false,
  scrolled: false,
  topBar: true,
  lastY: 0,

  init() {
    this.onScroll()
  },

  // Hides the dark top bar while scrolling down and brings it back on any scroll up
  onScroll() {
    const y = Math.max(window.scrollY, 0)
    const delta = y - this.lastY

    this.scrolled = y > 24

    if (y <= 24 || delta < -4) this.topBar = true
    else if (delta > 4 && y > 120) this.topBar = false

    if (Math.abs(delta) > 4) this.lastY = y
  },

  toggle() {
    this.open = !this.open
  },

  close() {
    this.open = false
  },
})
