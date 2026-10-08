# TODO

Ideas not yet built, practical and speculative alike.

## Font Awesome file-type icons

Today the extension only hides the file extension of attachments shown in a
post (`report.pdf` becomes `report`), which also hides the file type from
readers. Rework it to show a Font Awesome icon for the file type instead, so
the type stays visible.

Planned behavior:

- Applies to file attachments only (`S_FILE`). Inline images and thumbnails
  are left alone.
- The icon goes in prosilver's existing upload-icon slot in front of the file
  name (`{_file.UPLOAD_ICON}` in `attachment.html`), filled from the
  `core.parse_attachments_modify_template_data` event the extension already
  uses, so no template changes are needed. This covers posts, private
  messages and previews.
- Icons use the Font Awesome 4.7 that phpBB 3.3 ships:
  `fa-file-pdf-o`, `fa-file-word-o`, `fa-file-excel-o`,
  `fa-file-powerpoint-o`, `fa-file-image-o`, `fa-file-audio-o`,
  `fa-file-video-o`, `fa-file-archive-o`, `fa-file-code-o`,
  `fa-file-text-o`, and `fa-file-o` for anything else.
- Each icon gets a `title` and screen-reader text such as "PDF file", both
  from language strings.
- The file type is taken from the text after the **last** dot. Today's code
  cuts at the first dot, so `meeting.notes.2026.pdf` shows as `meeting`.

Still needs deciding:

- Whether hiding the extension text stays (always, never, or an ACP setting)
  now that the icon shows the type.
- Map icons by file extension, or by phpBB's extension groups (ACP »
  Posting » Attachments » Extension groups). Extensions are more precise;
  groups follow the board's own setup.
- What to do when an extension group already has one of phpBB's image
  upload icons: replace it, or keep it and skip the Font Awesome icon.
- phpBB 4.0 support. Checked against phpBB `master`: `attachment.html` has
  the same `{_file.UPLOAD_ICON}` slot and the event is unchanged, so the PHP
  side can be shared. 4.0 ships Font Awesome 6.5.1, which dropped the 4.7
  `-o` names, so the class names need a per-branch list: `fa-regular` plus
  `fa-file-pdf`, `fa-file-word`, `fa-file-excel`, `fa-file-powerpoint`,
  `fa-file-image`, `fa-file-audio`, `fa-file-video`, `fa-file-zipper`
  (was `fa-file-archive-o`), `fa-file-code`, `fa-file-lines` (was
  `fa-file-text-o`) and `fa-file`. Confirm on a 4.0 board that each has a
  free regular (outline) version; fall back to `fa-solid` if not.
- Whether the new purpose deserves a new display name. Changing the
  composer name or vendor is a bigger step, because existing installs then
  need moving over (see phpbbmodders/stopforumspam's `ext.php`).

Also due with the rework: correct the phpBB requirement in `composer.json`
(it claims `>=3.0.1-RC5`) and bring the README up to date (it still says
phpBB 3.1).
