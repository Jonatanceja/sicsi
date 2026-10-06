// extras: { fieldKey: 'Label sent in the email' } — each key maps to an input/select with id `q-<fieldKey>`
export default ({ endpoint, success, error, extras = {} }) => ({
  fields: { name: '', company: '', email: '', phone: '', ...Object.fromEntries(Object.keys(extras).map((key) => [key, ''])) },
  errors: {},
  status: 'idle', // idle | sending | sent | failed
  message: '',

  init() {
    // Preselect the first option of each <select> so the model matches what is shown
    this.$root.querySelectorAll('select').forEach((select) => {
      const key = select.id.replace('q-', '')
      if (select.options.length && key in this.fields) this.fields[key] = select.options[0].value
    })
  },

  validate() {
    this.errors = {}
    if (!this.fields.name.trim()) this.errors.name = true
    if (!this.fields.company.trim()) this.errors.company = true
    if (!/^\S+@\S+\.\S+$/.test(this.fields.email)) this.errors.email = true
    if (this.fields.phone.replace(/\D/g, '').length < 8) this.errors.phone = true

    return Object.keys(this.errors).length === 0
  },

  async submit() {
    if (this.status === 'sending' || !this.validate()) return

    this.status = 'sending'

    const { name, company, email, phone } = this.fields
    const extra = Object.fromEntries(Object.entries(extras).map(([key, label]) => [label, this.fields[key]]))

    try {
      await window.axios.post(
        endpoint,
        { name, company, email, phone, extra },
        { headers: { 'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.content } },
      )
      this.status = 'sent'
      this.message = success
      for (const key of ['name', 'company', 'email', 'phone']) this.fields[key] = ''
      Object.keys(extras).forEach((key) => {
        if (!this.$root.querySelector(`select#q-${key}`)) this.fields[key] = ''
      })
    } catch (e) {
      this.status = 'failed'
      this.message = e.response?.data?.message || error
    }
  },
})
