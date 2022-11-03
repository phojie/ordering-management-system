export interface TextField {
  // string
  id: string
  name?: string
  type?: string
  placeholder?: string
  modelValue?: string
  label?: string
  appendInnerIcon?: string
  errorMessage?: string
  autofocus?: boolean

  // boolean
  isDirty?: boolean
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
  isDirty?: boolean
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

export interface Btn {
  // string
  id?: string
  name?: string
  type?: 'submit' | 'reset' | 'button'
  label?: string
  variant?: 'primary' | 'danger' | 'secondary' | 'success' | 'warning'
  size?: 'small' | 'medium' | 'large'

  // boolean
  isDirty?: boolean
  isDisabled?: boolean
  isReadOnly?: boolean
  isLoading?: boolean

  // object
}

export interface Header {
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

export interface Items {
  [key: string]: any
}
