export interface TextField {
  // string
  id: string
  name?: string
  type?: string
  placeholder?: string
  modelValue?: string
  label?: string
  appendInnerIcon?: string
  hints?: string
  errorMessage?: string
  autofocus?: boolean

  // boolean
  isError?: boolean
  isDisabled?: boolean
  isReadOnly?: boolean
  isLoading?: boolean

  // object
}

export interface TextArea {
  // string
  id: string
  name?: string
  placeholder?: string
  modelValue?: string
  label?: string
  appendInnerIcon?: string
  errorMessage?: string

  // boolean
  isError?: boolean
  isDisabled?: boolean
  isReadOnly?: boolean
  isLoading?: boolean

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
  filter?: (value: any, search: string, item: any) => boolean
  divider?: boolean
  class?: string
  width?: string
}

export interface TableItems {
  [key: string]: any
}

export interface Notification {
  id: number
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
