export interface PaginationLink {
  url: string
  label: string
  active: boolean
}

export interface PaginationProps {
  data: Array<any>
  currentPage: number
  lastPage: number
  links: Array<PaginationLink>
  nextPageUrl: string
  prevPageUrl: string
}
