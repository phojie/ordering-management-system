export interface TextArea {
  // string
  id: string
  name?: string
  placeholder?: string
  modelValue?: string
  label?: string
  appendInner?: unknown
  prependInner?: unknown
  hints?: string
  errorMessage?: string
  inputClass?: string

  // boolean
  autofocus?: boolean
  isError?: boolean
  isDisabled?: boolean
  isReadOnly?: boolean
  isLoading?: boolean
  isClearable?: boolean

  // object

  // number
  rows?: number
}

export interface Checkbox {
  // string
  id: string
  name?: string
  modelValue?: boolean
  label?: string

  // boolean
  isDirty?: boolean
  isDisabled?: boolean
  isReadOnly?: boolean
  isLoading?: boolean

  // object
}

export interface TableHeader {
  text: string
  value: string
  sortable?: boolean
  align?: 'start' | 'center' | 'end'
  filterable?: boolean
  filterOptions?: {
    type: 'text' | 'select' | 'date' | 'number'
  }
  divider?: boolean
  class?: string
  width?: string
}

export interface TableItems {
  [key: string]: any
}

export interface Notification {
  id: number | string
  duration?: number

  title: string
  message?: string

  showClose?: boolean
  showIcon?: boolean

  variant?: 'success' | 'info' | 'warning' | 'danger'
  icon?: 'check' | 'info' | 'warning' | 'error' | 'trash' | 'restore'
  // TODO define this position options, it was not yet used
  position?: 'top-right' | 'top-left' | 'bottom-right' | 'bottom-left'

  // array
  actions?: Array<NotificationAction>
}

export interface NotificationAction {
  label: string
  url: URL
  data?: any
  method?: 'get' | 'post' | 'put' | 'patch' | 'delete'
}

export interface PaginationLink {
  url: string
  label: string
  active: boolean
}
