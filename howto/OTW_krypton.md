# OverTheWire: Krypton — complete walkthrough from Termux / guía completa desde Termux

> **Spoilers / Aviso de spoilers:** this guide reveals the technique and the key of every level. If it is your first run, try each level before reading the solution.
>
> **Credentials / Credenciales:** OverTheWire's rules for content creators ask you **not to publish the game passwords**. This guide therefore shows every command and every key, but the final password of each level appears as `<password>`. Run the commands and you will see it on your own terminal.
>
> **English** | [Español](#español)

Tested from Termux on Android (November 2026) against `krypton.labs.overthewire.org` on port `2231`.

Krypton is a cryptography wargame: seven steps, seven classic techniques, from Base64 to a weak LFSR stream cipher. You only need SSH and a terminal. No root, no Metasploit.

---

# English

## What is Krypton?

Krypton is the "crypto" wargame of OverTheWire. Unlike Bandit, where you learn Linux commands, here you learn to **break ciphers**:

| Level | Cipher | What you learn |
| --- | --- | --- |
| 0 → 1 | Base64 | encoding is not encryption |
| 1 → 2 | ROT13 | Caesar shift, `tr` |
| 2 → 3 | Caesar with hidden key | known-plaintext attack |
| 3 → 4 | Monoalphabetic substitution | frequency analysis |
| 4 → 5 | Vigenère, known key length | analyse column by column |
| 5 → 6 | Vigenère, unknown key length | index of coincidence |
| 6 → 7 | LFSR stream cipher | known-plaintext keystream recovery |

Rules of the game:

- The files of each level live in `/krypton/kryptonN/` and are only readable by the corresponding user and group.
- To move to level `N+1` you log in as `kryptonN+1` with the password recovered in level `N`.
- Level 0 is solved **on the website**, not on the server: the level 0 page gives you a Base64 string that decodes to the password of `krypton1`.
- The SSH port is **2231**, not 22.

## Requirements on Termux

```bash
pkg update
pkg install openssh coreutils python -y
# optional, convenient for one-liners and scp
pkg install sshpass -y
```

What each piece is for:

- `openssh`: `ssh` and `scp`.
- `coreutils`: `base64`, `tr`, `fold`, `cut`, `sort`, `uniq`.
- `python`: the cryptanalysis scripts for levels 4, 5 and 6.
- `sshpass`: non-interactive SSH (optional and discouraged for real hosts).

`xxd` is not installed by default in Termux. Use `hexdump -C` or install it with `pkg install xxd`. The Krypton server itself has `xxd`, `hexdump`, `perl` and `python3`.

## Connecting

The first connection is always interactive; the server asks for the password of the level:

```bash
ssh -p 2231 krypton1@krypton.labs.overthewire.org
```

To avoid typing the host and port every time, create `~/.ssh/config`:

```text
Host krypton
    HostName krypton.labs.overthewire.org
    Port 2231
    User krypton1
    StrictHostKeyChecking accept-new
```

Then `ssh krypton`. To change level, edit `User` or pass it explicitly:

```bash
ssh -p 2231 krypton2@krypton.labs.overthewire.org
```

Two small helpers (add them to `~/.bashrc` if you like):

```bash
# kt krypton3  -> interactive shell as krypton3
kt() {
  ssh -o StrictHostKeyChecking=accept-new -p 2231 \
      "$1@krypton.labs.overthewire.org"
}

# kscp krypton4 /krypton/krypton4/found1 .  -> copy a remote file here
kscp() {
  scp -P 2231 -o StrictHostKeyChecking=accept-new \
      "$1@krypton.labs.overthewire.org:$2" "${3:-.}"
}
```

Note the capital `-P` in `scp`; lowercase `-p` means "preserve timestamps".

### About `sshpass`

`sshpass -p 'password' ssh ...` works, but the password is visible in the process list and in your shell history. For recordings it is better to type the password by hand, or to use a file:

```bash
read -rsp 'password: ' KP; echo
sshpass -f <(printf '%s\n' "$KP") ssh -p 2231 krypton1@krypton.labs.overthewire.org
```

## Level 0 → Level 1: Base64

Open the level 0 page:

```text
https://overthewire.org/wargames/krypton/krypton0.html
```

It contains this string:

```text
S1JZUFRPTklTR1JFQVQ=
```

Base64 is an **encoding**, not encryption. Anyone can decode it:

```bash
echo 'S1JZUFRPTklTR1JFQVQ=' | base64 -d; echo
```

```text
S1JZUFRPTklTR1JFQVQ=   --base64 -d-->   <password>
        |                                   |
   encoded text                    plain text (credential)
```

The result is the password for `krypton1` (in uppercase). Log in with it:

```bash
ssh -p 2231 krypton1@krypton.labs.overthewire.org
```

Note: the Base64 string from the website is published by OverTheWire itself, so it is reproduced here; the decoded value is the credential and is not.

## Level 1 → Level 2: ROT13

From now on everything happens on the server. Once logged in as `krypton1`:

```bash
ls -la /krypton/krypton1
cat /krypton/krypton1/README
cat /krypton/krypton1/krypton2
```

The file `krypton2` contains:

```text
YRIRY GJB CNFFJBEQ EBGGRA
```

This is ROT13, a Caesar cipher with a shift of 13. Because 13 + 13 = 26, the same command encodes and decodes:

```bash
tr 'A-Za-z' 'N-ZA-Mn-za-m' < /krypton/krypton1/krypton2
```

Output (redacted):

```text
LEVEL TWO PASSWORD <password>
```

The five-letter grouping (`YRIRY GJB ...`) is a classic telegraph convention: group the ciphertext in blocks of five to hide word boundaries. Here the grouping is purely cosmetic; just translate it.

Why it works: `tr` maps every letter of the first set to the letter in the same position of the second set. `A` → `N`, `B` → `O`, ... `M` → `Z`, then it wraps to `A` for `N`, and so on.

```text
alphabet : A B C D E F G H I J K L M | N O P Q R S T U V W X Y Z
           | | | | | | | | | | | | |   | | | | | | | | | | | | |
ROT13    : N O P Q R S T U V W X Y Z | A B C D E F G H I J K L M
           \--------- +13 -----------/ \--------- +13 -----------/
```

The two halves of the alphabet are swapped. Applying the same command twice returns the original text, which is why ROT13 is used both to encode and to decode.

## Level 2 → Level 3: Caesar cipher with a hidden key

Log in as `krypton2` and look around:

```bash
ls -la /krypton/krypton2
cat /krypton/krypton2/krypton3
```

Ciphertext:

```text
OMQEMDUEQMEK
```

The directory also contains `encrypt`, a **setuid binary** that encrypts any file you give it with the secret key stored in `keyfile.dat` (which you cannot read):

```text
-rwsr-x--- 1 krypton3 krypton2 16336 ... encrypt
-rw-r----- 1 krypton3 krypton3    27 ... keyfile.dat
```

This is a **known-plaintext attack**. If you encrypt a message made only of `A`, every `A` becomes the first letter of the key alphabet, and the shift is exposed immediately.

The README already explains the trick, and gives the important detail: `encrypt` looks for `keyfile.dat` **in the current working directory**, and because it runs as `krypton3`, that directory must be accessible to `krypton3`.

```bash
d=$(mktemp -d); cd "$d"
ln -s /krypton/krypton2/keyfile.dat
chmod 777 .
printf 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA' > plain.txt
/krypton/krypton2/encrypt plain.txt
cat ciphertext
```

Output:

```text
MMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
```

```text
plain  : A B C D E F G H I J K L M N O P Q R S T U V W X Y Z
cipher : M N O P Q R S T U V W X Y Z A B C D E F G H I J K L
         \------------------- +12 -------------------/

known plaintext : A A A ...   ->   ciphertext : M M M ...   =>   shift = 12
to decrypt      : ciphertext - 12          (M - 12 = A)
```

So `A` (0) maps to `M` (12): the shift is **12**. Decrypt the ciphertext with the inverse shift, `cipher - 12`:

```bash
cat /krypton/krypton2/krypton3 | tr 'A-Z' 'OPQRSTUVWXYZABCDEFGHIJKLMN'
```

Output (redacted):

```text
<password>
```

That output is the password for `krypton3`.

Two checks that build intuition:

- Encrypt a second known text, for example `ABC`, and confirm that the three outputs are 12 positions apart.
- The `tr` set `OPQRSTUVWXYZABCDEFGHIJKLMN` is just "the alphabet starting at O", because `A` decrypted is `O`.

Do not leave the temporary directory behind (OverTheWire asks you to clean up):

```bash
cd ~
rm -rf "$d"
```

## Level 3 → Level 4: Monoalphabetic substitution

Log in as `krypton3`:

```bash
ls -la /krypton/krypton3
cat /krypton/krypton3/HINT1 /krypton/krypton3/HINT2
cat /krypton/krypton3/krypton4
```

The hints say it directly: *frequency analysis*. The ciphertext is:

```text
KSVVW BGSJD SVSIS VXBMN YQUUK BNWCU ANMJS
```

And you have three long messages encrypted with the **same key**: `found1`, `found2`, `found3`. The plaintexts are English.

Count the letters:

```bash
cat /krypton/krypton3/found1 /krypton/krypton3/found2 /krypton/krypton3/found3 \
  | tr -cd 'A-Z' | fold -w1 | sort | uniq -c | sort -rn | head -12
```

Result:

```text
    456 S
    340 Q
    301 J
    257 U
    246 B
    240 N
    227 C
    227 G
    210 D
    132 Z
    130 V
    129 W
```

```text
S  ####################  456   <- E
Q  ###############       340   <- T
J  #############         301   <- A
U  ###########           257   <- O
B  ###########           246   <- I
N  ##########            240   <- N
```

In English the order is roughly `E T A O I N S H R D L U`. So start with:

- `S` → `E`
- `Q` → `T`
- `J` → `A`
- `U` → `O`
- `B` → `I`
- `N` → `N`

Then refine with patterns: repeated letters inside words, common digraphs (`TH`, `HE`, `IN`, `ER`), common short words (`THE`, `AND`, `OF`, `TO`), and double letters (`SS`, `EE`, `LL`). The three files are long enough that the mapping converges quickly.

The recovered alphabet is:

```text
cipher: A B C D E F G H I J K L M N O P Q R S T U V W X Y Z
plain : B O I H G K N Q V T W Y U R X Z A J E M S L D F P C
```

Apply it with `tr`:

```bash
cat /krypton/krypton3/krypton4 | tr 'A-Z' 'BOIHGKNQVTWYURXZAJEMSLDFPC'
```

A faster, rougher shortcut: order the cipher alphabet by frequency and line it up with the English frequency order:

```bash
cat /krypton/krypton3/krypton4 \
  | tr 'SQJUBNGCDZVWMYTXKELAFIORHP' 'EATSORNIHCLDUPYFWGMBKVXQJZ'
```

It recovers this particular 35-letter message, but it is **not** the exact key: letters that never appear in `krypton4` (T, H, L, R) end up wrong. Use it to grab the password, and use the explicit mapping above when you want to read the long `foundN` files.

Output (redacted):

```text
WELLD ONETH ELEVE LFOUR PASSW ORDIS <password>
```

The password for `krypton4` is the last group.

Why substitution is weak: the mapping is fixed, so the statistical fingerprint of English (letter frequencies, digraphs, word shapes) survives the encryption. A single message of a few hundred letters is already enough; here you have three.

## Level 4 → Level 5: Vigenère with a known key length

Log in as `krypton4` and read the material:

```bash
ls -la /krypton/krypton4
cat /krypton/krypton4/HINT
cat /krypton/krypton4/krypton5
```

Ciphertext for level 5:

```text
HCIKV RJOX
```

The key length is **6**, and you have two long English messages (`found1`, `found2`) encrypted with the same key.

The Vigenère cipher uses a different Caesar shift per position, repeating the key:

```text
        col:  1  2  3  4  5  6 | 1  2  3  4  5  6
plain      :  T  H  E  S  O  L | D  I  E  R  W  I
key        :  F  R  E  K  E  Y | F  R  E  K  E  Y
cipher     :  Y  Y  I  C  S  J | I  Z  I  B  A  G
```

Every column uses one key letter, so each column is a plain Caesar cipher:

```text
col 1 -> F (shift  5)     col 4 -> K (shift 10)
col 2 -> R (shift 17)     col 5 -> E (shift  4)
col 3 -> E (shift  4)     col 6 -> Y (shift 24)
```

Because the key repeats, position 1 uses the first key letter, position 7 uses the same one, and so on. Split the text into six columns and each column is a plain Caesar cipher.

First bring the files to Termux (or work on the server, which has `python3`):

```bash
kscp krypton4 /krypton/krypton4/found1 .
kscp krypton4 /krypton/krypton4/found2 .
tr -cd 'A-Z' < found1 > found1.txt
```

**Important quirk:** Krypton restarts the key at the beginning of **every file**. Do not concatenate `found1` and `found2` before the analysis: the phase would break in the middle. Analyse each file separately, or align them.

Quick manual look at the first column:

```bash
fold -w6 found1.txt | cut -c1 | fold -w1 | sort | uniq -c | sort -rn | head -5
```

`fold -w6` cuts the stream into 6-letter rows, `cut -c1` keeps column 1, and the rest counts frequencies. The most frequent letter in that column is the encrypted `E` (or `T`), which gives the shift.

For a rigorous and reusable version, save this script as `vigenere.py`:

```python
#!/usr/bin/env python3
"""vigenere.py - Vigenere helper for Krypton (levels 4 and 5).

usage:  python3 vigenere.py ic  [maxlen] < text
        python3 vigenere.py crack <keylen> < text
"""
import sys
import collections
import string

EN = [8.167, 1.492, 2.782, 4.253, 12.702, 2.228, 2.015, 6.094, 6.966,
      0.153, 0.772, 4.025, 2.406, 6.749, 7.507, 1.929, 0.095, 5.987,
      6.327, 9.056, 2.758, 0.978, 2.360, 0.150, 1.974, 0.074]


def clean(s):
    return "".join(c for c in s.upper() if "A" <= c <= "Z")


def ic(s):
    n = len(s)
    c = collections.Counter(s)
    return sum(v * (v - 1) for v in c.values()) / (n * (n - 1))


def key_lengths(text, maxlen=20):
    print("length  avg index of coincidence")
    for L in range(1, maxlen + 1):
        avg = sum(ic(text[i::L]) for i in range(L)) / L
        print(f"{L:6d}  {avg:.4f}")


def chi(s):
    n = len(s)
    c = collections.Counter(s)
    return sum((c[ch] - EN[i] * n / 100) ** 2 / (EN[i] * n / 100)
               for i, ch in enumerate(string.ascii_uppercase))


def crack(text, L):
    key = ""
    for i in range(L):
        col = text[i::L]
        _, shift = min(
            (chi("".join(chr((ord(c) - 65 - s) % 26 + 65) for c in col)), s)
            for s in range(26)
        )
        key += chr(shift + 65)
    return key


if __name__ == "__main__":
    mode = sys.argv[1]
    text = clean(sys.stdin.read())
    if mode == "ic":
        key_lengths(text, int(sys.argv[2]) if len(sys.argv) > 2 else 20)
    else:
        print(crack(text, int(sys.argv[2])))
```

Run it on each file:

```bash
python3 vigenere.py crack 6 < found1.txt   # FREKEY
python3 vigenere.py crack 6 < found2.txt   # FREKEY
```

The key is `FREKEY`. Now decrypt the ten letters of `krypton5`:

```bash
python3 - <<'EOF'
ct  = "HCIKVRJOX"
key = "FREKEY"
print("".join(chr((ord(c) - 65 - ord(key[i % len(key)]) + 65) % 26 + 65)
              for i, c in enumerate(ct)))
EOF
```

Output (redacted): `<password>` (ten letters). Log in as `krypton5`.

## Level 5 → Level 6: Vigenère with an unknown key length

```bash
ls -la /krypton/krypton5
cat /krypton/krypton5/README
cat /krypton/krypton5/krypton6
```

Ciphertext:

```text
BELOS Z
```

Now the key length is unknown. You have three long messages (`found1`, `found2`, `found3`) and the same rule applies: the key restarts in every file.

The tool for this is the **index of coincidence** (IC): the probability that two random letters taken from the text are equal. English text has IC ≈ 0.066; a Caesar-encrypted (uniform) text has IC ≈ 0.038. If you split the text into `L` columns and the IC of the columns rises towards 0.066, then `L` is the key length.

```bash
kscp krypton5 /krypton/krypton5/found1 .
kscp krypton5 /krypton/krypton5/found2 .
kscp krypton5 /krypton/krypton5/found3 .
tr -cd 'A-Z' < found1 > f1.txt
tr -cd 'A-Z' < found2 > f2.txt
tr -cd 'A-Z' < found3 > f3.txt
python3 vigenere.py ic 15 < f1.txt
```

Relevant part of the output:

```text
     3  0.0515
     6  0.0518
     9  0.0700   <-- peak
    12  0.0523
    15  0.0512
    18  0.0708
```

The peaks at 9 and at multiples of 9 (18) reveal the length: **9**. A multiple of the real length also produces a peak, so always take the smallest strong one.

```text
ciphertext : [c1][c2][c3][c4][c5][c6][c7][c8][c9][c1][c2]...
key        :  K   E   Y   L   E   N   G   T   H   K   E  ...
             \_________________ 9 _________________/

IC low  (~0.04) -> columns are still mixed: wrong length
IC high (~0.07) -> columns look like English: right length
```

Now recover the key column by column, exactly as in level 4:

```bash
python3 vigenere.py crack 9 < f1.txt   # KEYLENGTH
python3 vigenere.py crack 9 < f2.txt   # KEYLENGTH
python3 vigenere.py crack 9 < f3.txt   # KEYLENGTH
```

The key is `KEYLENGTH` (nine letters). Decrypt the target:

```bash
python3 - <<'EOF'
ct  = "BELOSZ"
key = "KEYLENGTH"
print("".join(chr((ord(c) - 65 - ord(key[i % len(key)]) + 65) % 26 + 65)
              for i, c in enumerate(ct)))
EOF
```

Output (redacted): `<password>` (six letters). Log in as `krypton6`.

A sanity check that your key is right: decrypt a few lines of each `foundN` file and read English. If only some columns are garbled, the key length is a multiple of the real one.

## Level 6 → Level 7: LFSR stream cipher

```bash
ls -la /krypton/krypton6
cat /krypton/krypton6/HINT1 /krypton/krypton6/HINT2
cat /krypton/krypton6/krypton7
```

Ciphertext:

```text
PNUKLYLWRQKGKBE
```

`HINT2` says: **8 bit LFSR**. There is also `encrypt6`, another setuid binary, and an unreadable `keyfile.dat`. Unlike the previous levels, this one works on **bytes**, and the cipher is a stream cipher: it generates a pseudo-random keystream and combines it with the plaintext.

The README explains the weakness: *the "random" number generator is weak*, and the hints say it is **periodic**.

The attack is a known-plaintext attack. Encrypt a file full of `A` (byte `0x41`) and the output reveals the keystream directly. Same setup as level 2: the binary reads `keyfile.dat` from the current directory, and that directory must be writable by `krypton7`.

```text
keyfile.dat --> [ LFSR ] --> keystream (period 30) --+
                                                     |
plaintext "AAAA..." (0x41) -------------------------[+]--> ciphertext
```

```bash
d=$(mktemp -d); cd "$d"
ln -s /krypton/krypton6/keyfile.dat
chmod 777 .
head -c 400 /dev/zero | tr '\0' A > plain
/krypton/krypton6/encrypt6 plain cipher
wc -c cipher
hexdump -C cipher | head -3
```

`encrypt6` takes **two** arguments: source and destination. Output:

```text
400 cipher
00000000  45 49 43 54 44 47 59 49  59 5a 4b 54 48 4e 53 49  |EICTDGYIYZKTHNSI|
00000010  52 46 58 59 43 50 46 55  45 4f 43 4b 52 4e 45 49  |RFXYCPFUEOCKRNEI|
00000020  43 54 44 47 59 49 59 5a  4b 54 48 4e 53 49 52 46  |CTDGYIYZKTHNSIRF|
```

Two things to notice:

1. Every ciphertext byte is an uppercase letter, so the operation is modular addition over 26 letters (a Vigenère over bytes), not a bitwise XOR.
2. The block at offset `0x20` repeats the block at offset `0x02`, which means the keystream is **30 bytes long**.

Measure the period yourself:

```bash
python3 - <<'EOF'
c = open("cipher", "rb").read()
for p in range(2, 256):
    if all(c[i] == c[i % p] for i in range(len(c))):
        print("period:", p)
        break
EOF
```

```text
period: 30
```

```text
encrypt6 with plaintext "AAAA..." (A = 0):

plaintext  :  A  A  A  A  A  A  A  A  ...
keystream  :  E  I  C  T  D  G  Y  I  ...   (30 bytes, then repeats)
ciphertext :  E  I  C  T  D  G  Y  I  ...   (A + keystream = keystream)

krypton7   :  P  N  U  K  L  Y  L  W  R  Q  K  G  K  B  E
keystream  :  E  I  C  T  D  G  Y  I  Y  Z  K  T  H  N  S
              \___________________________________________/
                    subtract mod 26  ->  <password>
```

Now decrypt `krypton7`. Copy it into the working directory first:

```bash
cp /krypton/krypton6/krypton7 ./target
python3 - <<'EOF'
ct = open("target", "rb").read().strip()
ks = [(b - 0x41) % 26 for b in open("cipher", "rb").read()]
out = "".join(chr(65 + ((c - 0x41) - ks[i % 30]) % 26)
              for i, c in enumerate(ct))
print(out)
EOF
```

Output (redacted): `<password>`, fifteen uppercase letters. Log in as `krypton7`:

```bash
ssh -p 2231 krypton7@krypton.labs.overthewire.org
```

You will get:

```text
Congratulations on beating Krypton!
```

Why it works: with a known plaintext of `A` (value 0) the ciphertext **is** the keystream. And because the generator is deterministic and its period is only 30 characters, you can recover the keystream once and reuse it against any message encrypted with the same keyfile. That is exactly the sin that a one-time pad avoids: reusing a short key. The `onetime/` directory in the level shows the opposite idea (`plain1`, `key1`, `cipher1`).

You can confirm the determinism yourself: encrypt the same `plain` twice into `c1` and `c2` and compare them with `cmp -s c1 c2 && echo SAME`.

## Summary

| Level | Cipher | Key / technique | Tool |
| --- | --- | --- | --- |
| 0 → 1 | Base64 | decode from the website | `base64 -d` |
| 1 → 2 | ROT13 | shift 13 | `tr` |
| 2 → 3 | Caesar | shift 12, known plaintext with setuid `encrypt` | `printf`, `tr` |
| 3 → 4 | Monoalphabetic substitution | frequency analysis of `found1..3` | `tr`, `sort`, `uniq` |
| 4 → 5 | Vigenère, key length 6 | `FREKEY`, per-column analysis | `python3` |
| 5 → 6 | Vigenère, unknown length | IC → length 9, key `KEYLENGTH` | `python3` |
| 6 → 7 | LFSR stream | known plaintext, period 30 | `encrypt6`, `hexdump`, `python3` |

The passwords themselves are not listed here: OverTheWire asks content creators not to publish credentials. The commands above produce them.

## Troubleshooting

| Symptom | Cause / fix |
| --- | --- |
| `Permission denied` as `krypton0` | Level 0 is solved on the website. The decoded Base64 is the password for `krypton1`. |
| `Permission denied` as `kryptonN` | Wrong password, or you are using the password of the previous level. |
| `Host key verification failed` | `ssh -o StrictHostKeyChecking=accept-new ...`, or remove the old key from `~/.ssh/known_hosts`. |
| `sshpass: command not found` | `pkg install sshpass`. |
| `encrypt: cannot open keyfile.dat` (or similar) | You are not in a directory that contains `keyfile.dat`. Create the temp dir, symlink, `chmod 777 .`, and run the binary from there. |
| `encrypt6` prints a usage line | It needs two arguments: `encrypt6 <plaintext> <ciphertext>`. |
| `cat: /krypton/kryptonN/...: Permission denied` | You are logged in as the wrong level. The directory belongs to `kryptonN`. |
| The Vigenère key looks wrong in half the columns | You concatenated files before the analysis. The key restarts at the beginning of every file. |
| `xxd: command not found` on Termux | `pkg install xxd`, or use `hexdump -C`. |
| `tr: Illegal byte sequence` | Run `tr -cd 'A-Z'` first; the files may contain newlines or CRLF. |

## Cleanup

OverTheWire asks you to remove what you create. Use the exact path that `mktemp` printed (never a wildcard on the shared `/tmp`):

```bash
rm -rf "$d"
```

Then close the SSH session:

```bash
exit
```

## Recording from Termux

A few practical notes for the video series:

- Increase the font size before recording; five-letter groups are easy to misread.
- Never show the password on camera if you plan to publish the frames: use `read -rsp` or type it into a hidden prompt.
- Show the *reason* for each command, not only the command: ROT13 is a Caesar shift, the setuid binary leaks the key, the repeated block reveals the period.
- Record the cleanup too; it is part of the etiquette.
- `sshpass` is fine for a lab, but a video that teaches good habits should show an interactive `ssh`.

## Credits

Krypton and all the level material belong to the [OverTheWire](https://overthewire.org/wargames/krypton/) community. If you enjoy the games and you can afford it, [donate](https://overthewire.org/information/donate.html) — they run on volunteers.

---

## Traducción al español

# Español

## ¿Qué es Krypton?

Krypton es el wargame de criptografía de OverTheWire. A diferencia de Bandit, donde se aprenden comandos de Linux, aquí se aprende a **romper cifrados**:

| Nivel | Cifrado | Qué se aprende |
| --- | --- | --- |
| 0 → 1 | Base64 | codificar no es cifrar |
| 1 → 2 | ROT13 | desplazamiento César, `tr` |
| 2 → 3 | César con clave oculta | ataque de texto plano conocido |
| 3 → 4 | Sustitución monoalfabética | análisis de frecuencias |
| 4 → 5 | Vigenère con longitud conocida | analizar columna por columna |
| 5 → 6 | Vigenère sin longitud conocida | índice de coincidencia |
| 6 → 7 | Cifrado de flujo LFSR | recuperar el keystream con texto conocido |

Reglas del juego:

- Los archivos de cada nivel están en `/krypton/kryptonN/` y solo los puede leer el usuario y el grupo correspondientes.
- Para pasar al nivel `N+1` se inicia sesión como `kryptonN+1` con la contraseña obtenida en el nivel `N`.
- El nivel 0 se resuelve **en la web**, no en el servidor: la página del nivel 0 da una cadena Base64 que, al decodificarla, es la contraseña de `krypton1`.
- El puerto SSH es **2231**, no el 22.

## Requisitos en Termux

```bash
pkg update
pkg install openssh coreutils python -y
# opcional, cómodo para one-liners y scp
pkg install sshpass -y
```

Para qué sirve cada cosa:

- `openssh`: `ssh` y `scp`.
- `coreutils`: `base64`, `tr`, `fold`, `cut`, `sort`, `uniq`.
- `python`: los scripts de criptoanálisis de los niveles 4, 5 y 6.
- `sshpass`: SSH no interactivo (opcional y desaconsejado en hosts reales).

`xxd` no viene instalado por defecto en Termux. Usa `hexdump -C` o instálalo con `pkg install xxd`. El servidor de Krypton sí tiene `xxd`, `hexdump`, `perl` y `python3`.

## Conexión

La primera conexión siempre es interactiva; el servidor pide la contraseña del nivel:

```bash
ssh -p 2231 krypton1@krypton.labs.overthewire.org
```

Para no escribir host y puerto cada vez, crea `~/.ssh/config`:

```text
Host krypton
    HostName krypton.labs.overthewire.org
    Port 2231
    User krypton1
    StrictHostKeyChecking accept-new
```

Después basta con `ssh krypton`. Para cambiar de nivel, edita `User` o pásalo explícitamente:

```bash
ssh -p 2231 krypton2@krypton.labs.overthewire.org
```

Dos ayudantes (puedes añadirlos a `~/.bashrc`):

```bash
# kt krypton3  -> shell interactiva como krypton3
kt() {
  ssh -o StrictHostKeyChecking=accept-new -p 2231 \
      "$1@krypton.labs.overthewire.org"
}

# kscp krypton4 /krypton/krypton4/found1 .  -> trae un archivo remoto aquí
kscp() {
  scp -P 2231 -o StrictHostKeyChecking=accept-new \
      "$1@krypton.labs.overthewire.org:$2" "${3:-.}"
}
```

Ojo: en `scp` la `-P` va en mayúscula; la `-p` minúscula significa "preservar fechas".

### Sobre `sshpass`

`sshpass -p 'contraseña' ssh ...` funciona, pero la contraseña queda visible en la lista de procesos y en el historial del shell. Para grabar es mejor escribirla a mano o usar un archivo:

```bash
read -rsp 'contraseña: ' KP; echo
sshpass -f <(printf '%s\n' "$KP") ssh -p 2231 krypton1@krypton.labs.overthewire.org
```

## Nivel 0 → Nivel 1: Base64

Abre la página del nivel 0:

```text
https://overthewire.org/wargames/krypton/krypton0.html
```

Contiene esta cadena:

```text
S1JZUFRPTklTR1JFQVQ=
```

Base64 es una **codificación**, no un cifrado. Cualquiera puede decodificarla:

```bash
echo 'S1JZUFRPTklTR1JFQVQ=' | base64 -d; echo
```

```text
S1JZUFRPTklTR1JFQVQ=   --base64 -d-->   <contraseña>
        |                                   |
   texto codificado              texto plano (credencial)
```

El resultado es la contraseña de `krypton1` (en mayúsculas). Inicia sesión con ella:

```bash
ssh -p 2231 krypton1@krypton.labs.overthewire.org
```

Nota: la cadena Base64 la publica el propio OverTheWire en la página del nivel, por eso se reproduce aquí; el valor decodificado es la credencial y no se publica.

## Nivel 1 → Nivel 2: ROT13

A partir de aquí todo ocurre en el servidor. Ya como `krypton1`:

```bash
ls -la /krypton/krypton1
cat /krypton/krypton1/README
cat /krypton/krypton1/krypton2
```

El archivo `krypton2` contiene:

```text
YRIRY GJB CNFFJBEQ EBGGRA
```

Es ROT13, un César con desplazamiento 13. Como 13 + 13 = 26, el mismo comando cifra y descifra:

```bash
tr 'A-Za-z' 'N-ZA-Mn-za-m' < /krypton/krypton1/krypton2
```

Salida (censurada):

```text
LEVEL TWO PASSWORD <contraseña>
```

La agrupación en bloques de cinco (`YRIRY GJB ...`) es una convención telegráfica: agrupar el criptograma en bloques de cinco letras para ocultar los límites de las palabras. Aquí el agrupado es cosmético; solo hay que traducirlo.

Por qué funciona: `tr` asigna a cada letra del primer conjunto la letra que ocupa su misma posición en el segundo. `A` → `N`, `B` → `O`, ... `M` → `Z`, y al llegar a `N` vuelve a `A`, y así sucesivamente.

```text
alfabeto : A B C D E F G H I J K L M | N O P Q R S T U V W X Y Z
           | | | | | | | | | | | | |   | | | | | | | | | | | | |
ROT13    : N O P Q R S T U V W X Y Z | A B C D E F G H I J K L M
           \--------- +13 -----------/ \--------- +13 -----------/
```

Las dos mitades del alfabeto se intercambian. Aplicar el mismo comando dos veces devuelve el texto original; por eso ROT13 sirve tanto para cifrar como para descifrar.

## Nivel 2 → Nivel 3: César con clave oculta

Inicia sesión como `krypton2` y mira el directorio:

```bash
ls -la /krypton/krypton2
cat /krypton/krypton2/krypton3
```

Criptograma:

```text
OMQEMDUEQMEK
```

El directorio también contiene `encrypt`, un **binario setuid** que cifra cualquier archivo que le pases con la clave secreta guardada en `keyfile.dat` (que no puedes leer):

```text
-rwsr-x--- 1 krypton3 krypton2 16336 ... encrypt
-rw-r----- 1 krypton3 krypton3    27 ... keyfile.dat
```

Esto es un **ataque de texto plano conocido**. Si cifras un mensaje compuesto solo por `A`, cada `A` se convierte en la primera letra del alfabeto cifrado y el desplazamiento queda al descubierto.

El README ya explica el truco y da el detalle importante: `encrypt` busca `keyfile.dat` **en el directorio de trabajo actual**, y como se ejecuta como `krypton3`, ese directorio debe ser accesible para `krypton3`.

```bash
d=$(mktemp -d); cd "$d"
ln -s /krypton/krypton2/keyfile.dat
chmod 777 .
printf 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA' > plain.txt
/krypton/krypton2/encrypt plain.txt
cat ciphertext
```

Salida:

```text
MMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
```

```text
plano  : A B C D E F G H I J K L M N O P Q R S T U V W X Y Z
cifra  : M N O P Q R S T U V W X Y Z A B C D E F G H I J K L
         \------------------- +12 -------------------/

texto conocido : A A A ...   ->   criptograma : M M M ...   =>   desplazamiento = 12
para descifrar : criptograma - 12          (M - 12 = A)
```

Entonces `A` (0) pasa a `M` (12): el desplazamiento es **12**. Descifra con el desplazamiento inverso, `criptograma - 12`:

```bash
cat /krypton/krypton2/krypton3 | tr 'A-Z' 'OPQRSTUVWXYZABCDEFGHIJKLMN'
```

Salida (censurada):

```text
<password>
```

Esa salida es la contraseña de `krypton3`.

Dos comprobaciones que ayudan a entenderlo:

- Cifra otro texto conocido, por ejemplo `ABC`, y confirma que las tres salidas están separadas por 12 posiciones.
- El conjunto `OPQRSTUVWXYZABCDEFGHIJKLMN` es simplemente "el alfabeto empezando por O", porque `A` descifrado es `O`.

No dejes el directorio temporal: OverTheWire pide limpiar lo que creas.

```bash
cd ~
rm -rf "$d"
```

## Nivel 3 → Nivel 4: Sustitución monoalfabética

Inicia sesión como `krypton3`:

```bash
ls -la /krypton/krypton3
cat /krypton/krypton3/HINT1 /krypton/krypton3/HINT2
cat /krypton/krypton3/krypton4
```

Las pistas lo dicen directamente: *análisis de frecuencias*. El criptograma es:

```text
KSVVW BGSJD SVSIS VXBMN YQUUK BNWCU ANMJS
```

Y tienes tres mensajes largos cifrados con la **misma clave**: `found1`, `found2`, `found3`. Los textos planos están en inglés.

Cuenta las letras:

```bash
cat /krypton/krypton3/found1 /krypton/krypton3/found2 /krypton/krypton3/found3 \
  | tr -cd 'A-Z' | fold -w1 | sort | uniq -c | sort -rn | head -12
```

Resultado:

```text
    456 S
    340 Q
    301 J
    257 U
    246 B
    240 N
    227 C
    227 G
    210 D
    132 Z
    130 V
    129 W
```

```text
S  ####################  456   <- E
Q  ###############       340   <- T
J  #############         301   <- A
U  ###########           257   <- O
B  ###########           246   <- I
N  ##########            240   <- N
```

En inglés el orden aproximado es `E T A O I N S H R D L U`. Así que empieza con:

- `S` → `E`
- `Q` → `T`
- `J` → `A`
- `U` → `O`
- `B` → `I`
- `N` → `N`

Después refina con patrones: letras repetidas dentro de una palabra, dígrafos frecuentes (`TH`, `HE`, `IN`, `ER`), palabras cortas típicas (`THE`, `AND`, `OF`, `TO`) y letras dobles (`SS`, `EE`, `LL`). Los tres archivos son lo bastante largos para que el mapeo converja rápido.

El alfabeto recuperado es:

```text
cifrado: A B C D E F G H I J K L M N O P Q R S T U V W X Y Z
plano  : B O I H G K N Q V T W Y U R X Z A J E M S L D F P C
```

Aplícalo con `tr`:

```bash
cat /krypton/krypton3/krypton4 | tr 'A-Z' 'BOIHGKNQVTWYURXZAJEMSLDFPC'
```

Un atajo más rápido y más burdo: ordena el alfabeto cifrado por frecuencia y alinéalo con el orden de frecuencias del inglés:

```bash
cat /krypton/krypton3/krypton4 \
  | tr 'SQJUBNGCDZVWMYTXKELAFIORHP' 'EATSORNIHCLDUPYFWGMBKVXQJZ'
```

Recupera este mensaje concreto de 35 letras, pero **no** es la clave exacta: las letras que no aparecen en `krypton4` (T, H, L, R) quedan mal. Úsalo para sacar la contraseña, y usa el mapeo explícito de arriba cuando quieras leer los archivos largos `foundN`.

Salida (censurada):

```text
WELLD ONETH ELEVE LFOUR PASSW ORDIS <contraseña>
```

La contraseña de `krypton4` es el último grupo.

Por qué la sustitución es débil: el mapeo es fijo, así que la huella estadística del inglés (frecuencias, dígrafos, forma de las palabras) sobrevive al cifrado. Un solo mensaje de unos cientos de letras ya es suficiente; aquí tienes tres.

## Nivel 4 → Nivel 5: Vigenère con longitud de clave conocida

Inicia sesión como `krypton4` y lee el material:

```bash
ls -la /krypton/krypton4
cat /krypton/krypton4/HINT
cat /krypton/krypton4/krypton5
```

Criptograma para el nivel 5:

```text
HCIKV RJOX
```

La longitud de la clave es **6**, y tienes dos mensajes largos en inglés (`found1`, `found2`) cifrados con la misma clave.

El cifrado Vigenère usa un desplazamiento César distinto en cada posición, repitiendo la clave:

```text
        col:  1  2  3  4  5  6 | 1  2  3  4  5  6
plano      :  T  H  E  S  O  L | D  I  E  R  W  I
clave      :  F  R  E  K  E  Y | F  R  E  K  E  Y
cifra      :  Y  Y  I  C  S  J | I  Z  I  B  A  G
```

Cada columna usa una sola letra de la clave, así que cada columna es un César normal:

```text
col 1 -> F (desplazamiento  5)     col 4 -> K (desplazamiento 10)
col 2 -> R (desplazamiento 17)     col 5 -> E (desplazamiento  4)
col 3 -> E (desplazamiento  4)     col 6 -> Y (desplazamiento 24)
```

Como la clave se repite, la posición 1 usa la primera letra de la clave y la posición 7 usa la misma. Si divides el texto en seis columnas, cada columna es un César normal.

Primero trae los archivos a Termux (o trabaja en el servidor, que tiene `python3`):

```bash
kscp krypton4 /krypton/krypton4/found1 .
kscp krypton4 /krypton/krypton4/found2 .
tr -cd 'A-Z' < found1 > found1.txt
```

**Detalle importante:** Krypton reinicia la clave al principio de **cada archivo**. No concatenes `found1` y `found2` antes del análisis: la fase se rompería por la mitad. Analiza cada archivo por separado, o alinéalos.

Una mirada manual rápida a la primera columna:

```bash
fold -w6 found1.txt | cut -c1 | fold -w1 | sort | uniq -c | sort -rn | head -5
```

`fold -w6` corta el flujo en filas de 6 letras, `cut -c1` se queda con la columna 1, y el resto cuenta frecuencias. La letra más frecuente de esa columna será la `E` (o la `T`) cifrada, lo que da el desplazamiento.

Para una versión rigurosa y reutilizable, guarda este script como `vigenere.py`:

```python
#!/usr/bin/env python3
"""vigenere.py - ayudante de Vigenere para Krypton (niveles 4 y 5).

uso:  python3 vigenere.py ic  [maxlen] < texto
      python3 vigenere.py crack <longitud> < texto
"""
import sys
import collections
import string

EN = [8.167, 1.492, 2.782, 4.253, 12.702, 2.228, 2.015, 6.094, 6.966,
      0.153, 0.772, 4.025, 2.406, 6.749, 7.507, 1.929, 0.095, 5.987,
      6.327, 9.056, 2.758, 0.978, 2.360, 0.150, 1.974, 0.074]


def clean(s):
    return "".join(c for c in s.upper() if "A" <= c <= "Z")


def ic(s):
    n = len(s)
    c = collections.Counter(s)
    return sum(v * (v - 1) for v in c.values()) / (n * (n - 1))


def key_lengths(text, maxlen=20):
    print("longitud  indice de coincidencia medio")
    for L in range(1, maxlen + 1):
        avg = sum(ic(text[i::L]) for i in range(L)) / L
        print(f"{L:8d}  {avg:.4f}")


def chi(s):
    n = len(s)
    c = collections.Counter(s)
    return sum((c[ch] - EN[i] * n / 100) ** 2 / (EN[i] * n / 100)
               for i, ch in enumerate(string.ascii_uppercase))


def crack(text, L):
    key = ""
    for i in range(L):
        col = text[i::L]
        _, shift = min(
            (chi("".join(chr((ord(c) - 65 - s) % 26 + 65) for c in col)), s)
            for s in range(26)
        )
        key += chr(shift + 65)
    return key


if __name__ == "__main__":
    mode = sys.argv[1]
    text = clean(sys.stdin.read())
    if mode == "ic":
        key_lengths(text, int(sys.argv[2]) if len(sys.argv) > 2 else 20)
    else:
        print(crack(text, int(sys.argv[2])))
```

Ejecútalo sobre cada archivo:

```bash
python3 vigenere.py crack 6 < found1.txt   # FREKEY
python3 vigenere.py crack 6 < found2.txt   # FREKEY
```

La clave es `FREKEY`. Ahora descifra las diez letras de `krypton5`:

```bash
python3 - <<'EOF'
ct  = "HCIKVRJOX"
key = "FREKEY"
print("".join(chr((ord(c) - 65 - ord(key[i % len(key)]) + 65) % 26 + 65)
              for i, c in enumerate(ct)))
EOF
```

Salida (censurada): `<contraseña>` (diez letras). Inicia sesión como `krypton5`.

## Nivel 5 → Nivel 6: Vigenère con longitud de clave desconocida

```bash
ls -la /krypton/krypton5
cat /krypton/krypton5/README
cat /krypton/krypton5/krypton6
```

Criptograma:

```text
BELOS Z
```

Ahora la longitud de la clave es desconocida. Tienes tres mensajes largos (`found1`, `found2`, `found3`) y sigue valiendo la regla: la clave se reinicia en cada archivo.

La herramienta para esto es el **índice de coincidencia** (IC): la probabilidad de que dos letras tomadas al azar del texto sean iguales. El inglés tiene IC ≈ 0,066; un texto cifrado con César (uniforme) tiene IC ≈ 0,038. Si divides el texto en `L` columnas y el IC de las columnas sube hacia 0,066, entonces `L` es la longitud de la clave.

```bash
kscp krypton5 /krypton/krypton5/found1 .
kscp krypton5 /krypton/krypton5/found2 .
kscp krypton5 /krypton/krypton5/found3 .
tr -cd 'A-Z' < found1 > f1.txt
tr -cd 'A-Z' < found2 > f2.txt
tr -cd 'A-Z' < found3 > f3.txt
python3 vigenere.py ic 15 < f1.txt
```

Parte relevante de la salida:

```text
     3  0.0515
     6  0.0518
     9  0.0700   <-- pico
    12  0.0523
    15  0.0512
    18  0.0708
```

Los picos en 9 y en sus múltiplos (18) revelan la longitud: **9**. Un múltiplo de la longitud real también produce pico, así que toma siempre el menor de los picos fuertes.

```text
criptograma : [c1][c2][c3][c4][c5][c6][c7][c8][c9][c1][c2]...
clave       :  K   E   Y   L   E   N   G   T   H   K   E  ...
              \_________________ 9 _________________/

IC bajo  (~0,04) -> las columnas siguen mezcladas: longitud incorrecta
IC alto  (~0,07) -> las columnas parecen inglés: longitud correcta
```

Ahora recupera la clave columna por columna, igual que en el nivel 4:

```bash
python3 vigenere.py crack 9 < f1.txt   # KEYLENGTH
python3 vigenere.py crack 9 < f2.txt   # KEYLENGTH
python3 vigenere.py crack 9 < f3.txt   # KEYLENGTH
```

La clave es `KEYLENGTH` (nueve letras). Descifra el objetivo:

```bash
python3 - <<'EOF'
ct  = "BELOSZ"
key = "KEYLENGTH"
print("".join(chr((ord(c) - 65 - ord(key[i % len(key)]) + 65) % 26 + 65)
              for i, c in enumerate(ct)))
EOF
```

Salida (censurada): `<contraseña>` (seis letras). Inicia sesión como `krypton6`.

Una comprobación de que la clave es correcta: descifra unas líneas de cada `foundN` y lee inglés. Si solo algunas columnas salen mal, la longitud elegida es un múltiplo de la real.

## Nivel 6 → Nivel 7: Cifrado de flujo LFSR

```bash
ls -la /krypton/krypton6
cat /krypton/krypton6/HINT1 /krypton/krypton6/HINT2
cat /krypton/krypton6/krypton7
```

Criptograma:

```text
PNUKLYLWRQKGKBE
```

`HINT2` dice: **8 bit LFSR**. También hay `encrypt6`, otro binario setuid, y un `keyfile.dat` ilegible. A diferencia de los niveles anteriores, aquí se trabaja con **bytes** y el cifrado es de flujo: genera un keystream pseudoaleatorio y lo combina con el texto plano.

El README explica la debilidad: *el generador "aleatorio" es débil*, y las pistas dicen que es **periódico**.

El ataque es de texto plano conocido. Cifra un archivo lleno de `A` (byte `0x41`) y la salida revela el keystream directamente. La preparación es la misma que en el nivel 2: el binario lee `keyfile.dat` del directorio actual, y ese directorio debe ser escribible por `krypton7`.

```text
keyfile.dat --> [ LFSR ] --> keystream (se repite cada 30) --+
                                                             |
texto plano "AAAA..." (0x41) -------------------------------[+]--> criptograma
```

```bash
d=$(mktemp -d); cd "$d"
ln -s /krypton/krypton6/keyfile.dat
chmod 777 .
head -c 400 /dev/zero | tr '\0' A > plain
/krypton/krypton6/encrypt6 plain cipher
wc -c cipher
hexdump -C cipher | head -3
```

`encrypt6` recibe **dos** argumentos: origen y destino. Salida:

```text
400 cipher
00000000  45 49 43 54 44 47 59 49  59 5a 4b 54 48 4e 53 49  |EICTDGYIYZKTHNSI|
00000010  52 46 58 59 43 50 46 55  45 4f 43 4b 52 4e 45 49  |RFXYCPFUEOCKRNEI|
00000020  43 54 44 47 59 49 59 5a  4b 54 48 4e 53 49 52 46  |CTDGYIYZKTHNSIRF|
```

Dos cosas a notar:

1. Todos los bytes del criptograma son letras mayúsculas, así que la operación es una suma modular sobre 26 letras (un Vigenère sobre bytes), no un XOR bit a bit.
2. El bloque del desplazamiento `0x20` repite el bloque del desplazamiento `0x02`, lo que significa que el keystream mide **30 bytes**.

Mide el período tú mismo:

```bash
python3 - <<'EOF'
c = open("cipher", "rb").read()
for p in range(2, 256):
    if all(c[i] == c[i % p] for i in range(len(c))):
        print("periodo:", p)
        break
EOF
```

```text
periodo: 30
```

```text
encrypt6 con el texto plano "AAAA..." (A = 0):

texto plano :  A  A  A  A  A  A  A  A  ...
keystream   :  E  I  C  T  D  G  Y  I  ...   (30 bytes y se repite)
criptograma :  E  I  C  T  D  G  Y  I  ...   (A + keystream = keystream)

krypton7    :  P  N  U  K  L  Y  L  W  R  Q  K  G  K  B  E
keystream   :  E  I  C  T  D  G  Y  I  Y  Z  K  T  H  N  S
               \___________________________________________/
                     restar mod 26  ->  <contraseña>
```

Ahora descifra `krypton7`. Copia el archivo al directorio de trabajo primero:

```bash
cp /krypton/krypton6/krypton7 ./target
python3 - <<'EOF'
ct = open("target", "rb").read().strip()
ks = [(b - 0x41) % 26 for b in open("cipher", "rb").read()]
out = "".join(chr(65 + ((c - 0x41) - ks[i % 30]) % 26)
              for i, c in enumerate(ct))
print(out)
EOF
```

Salida (censurada): `<contraseña>`, quince letras mayúsculas. Inicia sesión como `krypton7`:

```bash
ssh -p 2231 krypton7@krypton.labs.overthewire.org
```

Verás:

```text
Congratulations on beating Krypton!
```

Por qué funciona: con un texto plano conocido de `A` (valor 0), el criptograma **es** el keystream. Y como el generador es determinista y su período es de solo 30 caracteres, puedes recuperar el keystream una vez y reutilizarlo contra cualquier mensaje cifrado con el mismo `keyfile`. Ese es exactamente el pecado que evita una libreta de un solo uso: reutilizar una clave corta. El directorio `onetime/` del nivel muestra la idea contraria (`plain1`, `key1`, `cipher1`).

Puedes comprobar el determinismo tú mismo: cifra dos veces el mismo `plain` en `c1` y `c2` y compáralos con `cmp -s c1 c2 && echo SAME`.

## Resumen

| Nivel | Cifrado | Clave / técnica | Herramienta |
| --- | --- | --- | --- |
| 0 → 1 | Base64 | decodificar desde la web | `base64 -d` |
| 1 → 2 | ROT13 | desplazamiento 13 | `tr` |
| 2 → 3 | César | desplazamiento 12, texto conocido con `encrypt` setuid | `printf`, `tr` |
| 3 → 4 | Sustitución monoalfabética | análisis de frecuencias de `found1..3` | `tr`, `sort`, `uniq` |
| 4 → 5 | Vigenère, longitud 6 | `FREKEY`, análisis por columnas | `python3` |
| 5 → 6 | Vigenère, longitud desconocida | IC → longitud 9, clave `KEYLENGTH` | `python3` |
| 6 → 7 | Flujo LFSR | texto conocido, período 30 | `encrypt6`, `hexdump`, `python3` |

Las contraseñas no se listan aquí: OverTheWire pide a los creadores de contenido no publicar credenciales. Los comandos de arriba las producen.

## Solución de problemas

| Síntoma | Causa / solución |
| --- | --- |
| `Permission denied` como `krypton0` | El nivel 0 se resuelve en la web. El Base64 decodificado es la contraseña de `krypton1`. |
| `Permission denied` como `kryptonN` | Contraseña incorrecta, o estás usando la del nivel anterior. |
| `Host key verification failed` | `ssh -o StrictHostKeyChecking=accept-new ...`, o borra la clave vieja de `~/.ssh/known_hosts`. |
| `sshpass: command not found` | `pkg install sshpass`. |
| `encrypt: cannot open keyfile.dat` (o similar) | No estás en un directorio que contenga `keyfile.dat`. Crea el directorio temporal, el symlink, `chmod 777 .` y ejecuta el binario desde ahí. |
| `encrypt6` muestra una línea de uso | Necesita dos argumentos: `encrypt6 <texto_plano> <criptograma>`. |
| `cat: /krypton/kryptonN/...: Permission denied` | Estás en el nivel equivocado. El directorio pertenece a `kryptonN`. |
| La clave de Vigenère sale mal en la mitad de las columnas | Concatenaste archivos antes del análisis. La clave se reinicia al principio de cada archivo. |
| `xxd: command not found` en Termux | `pkg install xxd`, o usa `hexdump -C`. |
| `tr: Illegal byte sequence` | Ejecuta antes `tr -cd 'A-Z'`; los archivos pueden traer saltos de línea o CRLF. |

## Limpieza

OverTheWire pide borrar lo que creas. Usa la ruta exacta que imprimió `mktemp` (nunca un comodín en el `/tmp` compartido):

```bash
rm -rf "$d"
```

Después cierra la sesión SSH:

```bash
exit
```

## Grabando desde Termux

Notas prácticas para la serie de videos:

- Aumenta el tamaño de la fuente antes de grabar; los grupos de cinco letras se leen mal.
- No muestres la contraseña en cámara si vas a publicar los fotogramas: usa `read -rsp` o escríbela en un prompt oculto.
- Explica el *porqué* de cada comando, no solo el comando: ROT13 es un César, el binario setuid filtra la clave, el bloque repetido revela el período.
- Graba también la limpieza; es parte de la etiqueta.
- `sshpass` está bien en un laboratorio, pero un video que enseña buenas costumbres debería mostrar un `ssh` interactivo.

## Créditos

Krypton y todo el material de los niveles pertenecen a la comunidad de [OverTheWire](https://overthewire.org/wargames/krypton/). Si disfrutas los juegos y puedes permitírtelo, [dona](https://overthewire.org/information/donate.html): funcionan con voluntarios.
