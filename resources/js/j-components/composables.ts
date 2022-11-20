import type { TableHeader } from './types'
import HeroiconsChevronDown20Solid from '~icons/heroicons/chevron-down-20-solid'
import HeroiconsChevronUp20Solid from '~icons/heroicons/chevron-up-20-solid'
import HeroiconsMagnifyingGlassPlus20Solid from '~icons/heroicons/magnifying-glass-plus-20-solid'
import HeroiconsMagnifyingGlassMinus20Solid from '~icons/heroicons/magnifying-glass-minus-20-solid'

export const useJTable = () => {
  //  sorts area
  const sorts = (id: string) => {
    // get the route params sort value
    const sort = route().params.sort as string

    if (sort) {
      let sortArray = _.split(sort, ',') as any[]

      const findId = _.findIndex(sortArray, (item) => {
        return item === id || item === `-${id}`
      })

      // if not included in sort array, then add it
      if (findId !== -1) {
        sortArray[findId] = sortArray[findId].includes('-')
          ? undefined // sort remove
          : `-${sortArray[findId]}`
      }
      else {
        sortArray.push(id)
      }

      // remove undefined
      sortArray = _.compact(sortArray)

      return sortArray.length > 0 ? _.join(sortArray, ',') : undefined
    }
    else {
      return id
    }
  }

  const isSortExist = (id: string) => {
    // is sort exist in route params sort value
    const sort = route().params.sort as string

    if (sort) {
      const sortArray = _.split(sort, ',') as any[]

      const findId = _.findIndex(sortArray, (item) => {
        return item === id || item === `-${id}`
      })

      return findId !== -1
    }
  }

  const sortLink = (header: TableHeader) => {
    const sortData = sorts(header.value) as string
    return route(useRoute().currentRoute, {
      ...route().params as any,
      sort: sortData as string,
    })
  }

  const sortIcon = (header: TableHeader) => {
    const sort = route().params.sort as string

    if (sort) {
      const sortArray = _.split(sort, ',') as any[]

      const findId = _.findIndex(sortArray, (item) => {
        return item === header.value || item === `-${header.value}`
      })

      if (findId !== -1)
        return sortArray[findId].includes('-') ? HeroiconsChevronUp20Solid : HeroiconsChevronDown20Solid
    }

    return HeroiconsChevronDown20Solid
  }

  const sortIndex = (header: TableHeader) => {
    const sort = route().params.sort as string
    if (sort) {
      const sortArray = _.split(sort, ',') as any[]
      const findId = _.findIndex(sortArray, (item) => {
        return item === header.value || item === `-${header.value}`
      })

      if (findId !== -1)

        return findId + 1
    }

    return undefined
  }

  const isFilterExist = (id: string) => {
    return _.has(route().params.filter, id)
  }

  const filterIcon = (id: string) => {
    if (isFilterExist(id))
      return HeroiconsMagnifyingGlassMinus20Solid

    return HeroiconsMagnifyingGlassPlus20Solid
  }

  const filterFetch = (value: Object) => {
    Inertia.get(route(useRoute().currentRoute), {
      ...route().params as any,
      filter: value,
    },
    {
      preserveState: true,
      preserveScroll: true,
    },
    )
  }

  return {
    sortLink,
    sortIcon,
    sortIndex,
    isSortExist,

    filterFetch,
    filterIcon,
    isFilterExist,
  }
}
