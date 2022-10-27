export interface Menu {
  name: string
  description: string
  punch_line: string
  id?: number
  image_url?: string
  status?: MenuStatus
  created_by_id?: string
  created_at?: string
}

// enum status
export enum MenuStatus {
  ACTIVE = 'active',
  INACTIVE = 'inactive',
}
