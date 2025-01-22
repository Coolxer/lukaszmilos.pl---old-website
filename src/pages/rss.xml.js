import rss from "@astrojs/rss"
import { getCollection } from "astro:content"
import data from "~/data/site.json"

export async function GET(context) {
  const blog = (await getCollection("blog")).filter((post) => !post.data.draft)

  // const projects = (await getCollection("projects")).filter((project) => !project.data.draft)

  // const items = [...blog, ...projects].sort((a, b) => new Date(b.data.date).valueOf() - new Date(a.data.date).valueOf())

  // return rss({
  //   title: SITE.TITLE,
  //   description: SITE.DESCRIPTION,
  //   site: context.site,
  //   items: items.map((item) => ({
  //     title: item.data.title,
  //     description: item.data.description,
  //     pubDate: item.data.date,
  //     link: `/${item.collection}/${item.id}/`,
  //   })),
  // })

  return rss({
    title: data.site.meta["home-title"],
    description: data.site.meta["home-description"],
    site: context.site,
    customData: "<language>pl</language>",
    trailingSlash: true,
    items: blog.map((post) => ({
      title: post.data.title,
      link: `/blog/${post.id}/`,
      pubDate: post.data.date,
      description: post.data.description,
      categories: post.data.categories,
    })),
  })
}
