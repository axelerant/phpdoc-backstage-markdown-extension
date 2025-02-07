# phpdoc-backstage-markdown-extension

This repository contains a **phpDocumentor extension** that provides **Twig filters and functions** for the [phpdoc-backstage-markdown-theme](https://github.com/axelerant/phpdoc-backstage-markdown-theme). It leverages phpDocumentor’s **extension-based features**, which are currently only available in the **nightly (unstable) release** of phpDocumentor.

---

## Prerequisites

1. **phpDocumentor** (Nightly/Unstable Release)
   - [Installation guide](https://docs.phpdoc.org/3.0/guide/getting-started/installing.html)
   - The extension framework in phpDocumentor is **not yet available** in the stable releases.
2. **phpdoc-backstage-markdown-theme**
   - [GitHub Repository](https://github.com/axelerant/phpdoc-backstage-markdown-theme)

---

## Installation

1. **Clone or download** this repository:

~~~~bash
git clone https://github.com/axelerant/phpdoc-backstage-markdown-extension.git
~~~~

2. **Place the `phpdoc-backstage-markdown-extension` directory** in your project’s `.phpdoc/extensions` directory:

~~~~bash
cp -R phpdoc-backstage-markdown-extension /path/to/your/project/.phpdoc/extensions/
~~~~

Once installed, this extension will be available to phpDocumentor’s nightly builds, providing additional Twig filters and functions for use with **phpdoc-backstage-markdown-theme**.
