import { z, reference } from "astro:content"

export const metaSchema = 
  z.object({
    title: z.string().max(50),
    description: z.string().max(130),

    canonical: z.string().url().optional(),

    noindex: z.boolean().optional(),
    nofollow: z.boolean().optional(),

    charset: z.string().optional(),

    image: z
      .object({
        src: z.string().optional(),
        alt: z.string().optional(),
      })
      .optional(),

    languageAlternates: z
      .array(z.object({ href: z.string(), hrefLang: z.string() }))
      .optional(),

    og: z.boolean().optional(),
    tw: z.boolean().optional(),

    openGraph: z
      .object({
        basic: z
          .object({
            title: z.string().optional(),
            type: z.string().optional(),
            image: z.string().optional(),
            url: z.string().optional(),
          })
          .optional(),
        optional: z
          .object({
            audio: z.string().optional(),
            description: z.string().optional(),
            determiner: z.string().optional(),
            locale: z.string().optional(),
            localeAlternate: z.array(z.string()).optional(),
            siteName: z.string().optional(),
            video: z.string().optional(),
          })
          .optional(),
        image: z
          .object({
            url: z.string().optional(),
            secureUrl: z.string().optional(),
            type: z.string().optional(),
            width: z.number().optional(),
            height: z.number().optional(),
            alt: z.string().optional(),
          })
          .optional(),
        article: z
          .object({
            publishedTime: z.string().optional(),
            modifiedTime: z.string().optional(),
            expirationTime: z.string().optional(),
            authors: z.array(z.string()).optional(),
            section: z.string().optional(),
            tags: z.array(z.string()).optional(),
          })
          .optional(),
      })
      .optional(),

    twitter: z
      .object({
        card: z
          .enum(["summary", "summary_large_image", "app", "player"])
          .optional(),
        site: z.string().optional(),
        creator: z.string().optional(),
        title: z.string().optional(),
        image: z.string().optional(),
        imageAlt: z.string().optional(),
        description: z.string().optional(),
      })
      .optional(),
  })

export const blogSchema = z.object({
    meta: metaSchema,
    // focusKeyword
    // otherKeywords
    heading: z.string(),
    subheading: z.string(),
    leading: z.string(),
    image: z.object({
      src: z.string(),
      alt: z.string(),
    }),
    video: z.string().optional(),
    //categories: z.array(z.string()).default(['brak kategorii']),
    categories: z
      .array(
        z.enum(["brak kategorii", "biznes", "www", "cyfryzacja", "automatyzacja"])
      )
      .default(["brak kategorii"]),
    // tags: z.array(z.string()).optional(),
    knowledgeBase: z.boolean().default(false),
    relatedPosts: z.array(reference("blog")).max(3).optional(),
    date: z.coerce.date(),
    author: z.string().optional(),
    draft: z.boolean().optional(),
  })


  export const portfolioSchema = z.object({
    order: z.number(),
    meta: metaSchema,
    title: z.string(),
    problem: z.string(),
    target: z.string(),
    result: z.string(),
    image: z.object({
      src: z.string(),
      alt: z.string(),
    }),

    webMetrics: z.object({
      speed: z.number().optional(),
      accessibility: z.number().optional(),
      technics: z.number().optional(),
      seo: z.number().optional(),
      views: z.number().optional(),
      clicks: z.number().optional(),
    }).optional(),

   

    link: z.string().url().optional(),
    videos: z.array(z.string()).optional(),
    category: 
        z.enum(["www", "aplikacja", "automatyzacja"]),
    draft: z.boolean().optional(),
  })


