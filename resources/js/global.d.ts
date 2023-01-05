export interface Pagination {
  links: PaginationLinks
  meta: PaginationMeta
}

export interface PaginationLink {
  url: string
  label: string
  active: boolean
}

export interface PaginationLinks {
  first: string
  last: string
  prev: string
  next: string
}

export interface PaginationProps {
  data: Array<any>
  currentPage: number
  lastPage: number
  links: Array<PaginationLink>
  nextPageUrl: string
  prevPageUrl: string
}

export interface PaginationMeta {
  current_page: number
  from: number
  last_page: number
  path: string
  links: Array<PaginationLink>
  per_page: number
  to: number
  total: number
}

declare global {
  interface Window {
    Echo?: any;
  }
}
