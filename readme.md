## RSS 接口如下（Atom 格式）

## 获取 Github 项目中新增的中国活跃用户

格式：`http://www.archya.com/rss/github-recently-mentionable-chinese/:owner/:name`

参数：

| 参数名 | 意义 |
| ------ | ------ |
| owner | github 项目的用户名 `facebook/react` 中的 `facebook` |
| name | github 项目的项目名 `facebook/react` 中的 `react` |

范例：

http://www.archya.com/rss/github-recently-mentionable-chinese/ant-design/ant-design

原理：

通过 Github Api 获取每个项目的 mentionableUsers 列表，每当有**中国**新用户出现就更新到 RSS 中，包含用户的公开信息。
