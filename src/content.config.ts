import { defineCollection } from "astro:content"
import { blogSchema, portfolioSchema } from './content-schemas';
import { glob } from 'astro/loaders';


const blog = defineCollection({
  loader: glob({ pattern: '**/[^_]*.{md,mdx}', base: "./src/data/blog" }),
  schema: blogSchema,
})

const portfolio = defineCollection({
  loader: glob({ pattern: '**/[^_]*.{md,mdx}', base: "./src/data/portfolio" }),
  schema: portfolioSchema,
})

export const collections = {
  blog, portfolio
}
