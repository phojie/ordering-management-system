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

  // number
  rows?: number
}